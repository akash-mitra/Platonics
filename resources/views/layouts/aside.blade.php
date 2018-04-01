<aside class="{{ $width }} blog-sidebar">

    @if($side === 'left' && isset($meta["left"]))
        @foreach($meta["left"] as $key => $module)
            {!! App\RenderModule::getModuleHTML($key, $module, $pageMeta) !!}
        @endforeach
    @endif

    @if($side === 'right' && isset($meta["right"]))
        @foreach($meta["right"] as $key => $module)
            {!! App\RenderModule::getModuleHTML($key, $module, $pageMeta) !!}
        @endforeach
    @endif
    
</aside><!-- /.blog-sidebar -->
