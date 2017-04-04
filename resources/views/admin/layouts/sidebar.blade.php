<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Manejo de bots<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('bots.index')}}">Bots</a>
                    </li>
                </ul>
            </li>
            @if(isset($pages))
                @foreach($pages as $page)
                    <li>
                        <a href="#" ><i class="fa fa-file-code-o fa-fw"></i>{{$page->name}}<span class="fa arrow"></span></a>
                        <!--<ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i></i>Pagina de test</a>
                            </li>
                        </ul>
                        -->
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>