<aside class="{{ $width }} blog-sidebar">

    @if($side === 'left' && isset($meta["left-modules"]))
        @foreach($meta["left-modules"] as $module)
            {!! App\RenderModule::getModuleHTML($module) !!}
        @endforeach
    @endif

    @if($side === 'right' && isset($meta["right-modules"]))
        @foreach($meta["right-modules"] as $module)
            {!! App\RenderModule::getModuleHTML($module) !!}
        @endforeach
    @endif
    
</aside><!-- /.blog-sidebar -->
