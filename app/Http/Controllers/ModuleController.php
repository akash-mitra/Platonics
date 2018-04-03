<?php

namespace App\Http\Controllers;

use DB;
use App\Module;
use App\Configuration;
use Illuminate\Http\Request;

class ModuleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin');

        parent::__construct();
    }
    

    
    public function home()
    {
        return view('module.home');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
    
        return response()->json([
            "status" => "success",
            "message" => "Modules data attached",
            "count" => count($modules),
            "data" => $modules
        ]);
    }



    /**
     * Display the specified resource based on the Id.
     * If the provided Id is empty, displays empty form.
     *
     * @param  string $type
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function showOrCreate($type, $id = null)
    {
        if (empty($id)) {
            $module = new Module();
            $module->type = $type;
        } else {
            $module = Module::findOrFail($id);
        }

        return view('module.createOrShow', [
            "id" => $module->id,
            "name" => $module->name,
            "type" => $module->type,
            "config" => unserialize($module->config)
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrCreate(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $type = $request->input('type');
        $config = serialize($request->input('config'));
     
        $module = Module::updateOrCreate(["id" => $id], [
            "name" => $name,
            "type" => $type,
            "config" => $config
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Module successfully " . (empty($id)? "created." : "updated."),
            "module" => $module,
            "url" => route('module-show', $module->id)
        ]);
    }



    /**
     * Remove the specified module.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');

        $module = Module::findOrFail($id);

        // before deleting the module, make sure
        // we also delete the module info from meta
        $this->deleteModuleInMeta($id);
    
        DB::beginTransaction();
        try {
            $module->delete();
            $meta = serialize($this->meta);
            $this->updateBlogMetaInDB($meta);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "status"  => "failure",
                "message" => "Module (or related metadata info) could not be deleted",
                "data"    => $e->getErrors()
            ]);
        }

        return response()->json([
            "status" => "success",
            "message" => "Module successfully deleted"
        ]);
    }



    /**
     * Save module visibility related information
     * in the meta configuration
     */
    public function saveModuleMeta(Request $request)
    {
        //TODO
        //validation

        
        $moduleId        = $request->input('moduleId');
        $exceptions      = preg_replace('/\s/', '', $request->input('exceptions')); // remove all white spaces
        $exceptions      = empty($exceptions) ? null : explode(',', $exceptions);
        
        // create the module position class
        $module  = [
            "id"         => $request->input('moduleId'),
            "position"   => $request->input('position'),
            "visible"    => (array) $request->input('categories'),
            "exceptions" => $exceptions
        ];

        // delete the module if present in existing meta
        $this->deleteModuleInMeta($moduleId);

        // insert the new module in meta
        $this->insertOrUpdateModuleInMeta($module);

        // save the entire meta back to database
        $meta = serialize($this->meta);

        $this->updateBlogMetaInDB($meta);

        return response()->json([
            "status" => "success",
            "message" => "Module Visibility Stored Successfully",
            "meta" => $this->meta
        ]);
    }


    /**
     * Updates the serialized version of the blog
     * meta information to the database
     */
    private function updateBlogMetaInDB($meta)
    {
        $config = Configuration::where('key', 'blog')->first();
        
        $config->value = $meta;
        
        return $config->save();
    }



    private function insertOrUpdateModuleInMeta($module)
    {
        $moduleId = $module['id'];
        
        $modulePosition = $module['position'];
        
        $this->addModuleToMetaPositions($moduleId, $modulePosition, $module);

        $this->addModuleScriptToMetaScripts($moduleId);
    }



    private function deleteModuleInMeta($moduleId)
    {
        
        $this->removeModuleFromMetaPositions($moduleId);

        $this->removeModuleScriptFromMetaScripts($moduleId);
    }



    private function addModuleToMetaPositions($moduleId, $modulePosition, $module)
    {
        if (array_key_exists($modulePosition, $this->meta)) {
            //
            // intended position for the module already exists (even if empty)
            // just add this module in that placeholder position.
            //
            $this->meta[$modulePosition][$moduleId] = $module;
        } else {
            //
            // create the placeholder position itself, then add the module.
            //
            $this->meta[$modulePosition] = [$moduleId => $module];
        }
    }



    private function addModuleScriptToMetaScripts($moduleId)
    {
        $script = $this->getModuleScript($moduleId);

        if ($script != null && (!in_array($script, $this->meta['scripts']))) {
            array_push($this->meta['scripts'], $script);
        }
    }



    private function removeModuleFromMetaPositions($moduleId)
    {
        foreach ($this->meta['positions'] as $position) {
            if (array_key_exists($position, $this->meta)) {
                unset($this->meta[$position][$moduleId]);
            }
        }
    }



    private function removeModuleScriptFromMetaScripts($moduleId)
    {
        $script = $this->getModuleScript($moduleId);

        if (!$script) {
            unset($this->meta['scripts'][$script]);
        }
    }



    private function getModuleScript($moduleId)
    {
        $config = Module::findOrFail($moduleId)->config;

        $configArray = unserialize($config);

        if (isset($configArray['script'])) {
            return $configArray['script'];
        }

        return null;
    }
}
