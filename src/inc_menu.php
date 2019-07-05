<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?= ($mod == 'home') ? 'active' : ''; ?>" href="sistema.php?mod=home">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
                <!--icon-note icon-people-->

                <li class="nav-title">Modulos </li>
                <?php
                if (in_array($core->_vars['user']['ga'], array(1, 2))) {
                    ?>                         
                    <li class="nav-item nav-dropdown <?= ($mod == 'usuarios') ? 'open' : ''; ?>">                    
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-people"></i> Usuários</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link  <?= ($mod == 'usuarios' && $ver == 'lista') ? 'active' : ''; ?>" href="sistema.php?mod=usuarios&ver=lista">
                                    <i class="nav-icon icon-list"></i>Lista</a>
                            </li>                           
                            <li class="nav-item">
                                <a class="nav-link  <?= ($mod == 'usuarios' && $ver == 'novo') ? 'active' : ''; ?>" href="sistema.php?mod=usuarios&ver=novo">
                                    <i class="nav-icon icon-plus"></i>Novo</a>
                            </li>                           
                        </ul>
                    </li> 
                    <?php
                }
                if (in_array($core->_vars['user']['ga'], array(1, 3))) {
                    ?>                         
                    <li class="nav-item nav-dropdown <?= ($mod == 'operacoes') ? 'open' : ''; ?>">                    
                        <a class="nav-link nav-dropdown-toggle " href="#">
                            <i class="nav-icon icon-directions"></i>Operação</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link <?= ($mod == 'operacoes' && $ver == 'lista') ? 'active' : ''; ?>" href="sistema.php?mod=operacoes&ver=lista">
                                    <i class="nav-icon icon-list"></i>Lista</a>
                            </li> 
                            <?php
                            if (in_array($core->_vars['user']['ga'], array(1))) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= ($mod == 'operacoes' && $ver == 'novo') ? 'active' : ''; ?>" href="sistema.php?mod=operacoes&ver=novo">
                                        <i class="nav-icon icon-plus"></i>Novo</a>
                                </li>  
                                <?php
                            }
                            ?>
                        </ul>
                    </li> 
                    <?php
                }
                if (in_array($core->_vars['user']['ga'], array(3))) {
                    ?>                         
                    <li class="nav-item nav-dropdown <?= ($mod == 'tabloides') ? 'open' : ''; ?>">                    
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-note"></i> Tabloides</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link <?= ($mod == 'tabloides' && $ver == 'lista') ? 'active' : ''; ?>" href="sistema.php?mod=tabloides">
                                    <i class="nav-icon icon-list"></i>Lista</a>
                            </li>                           
                            <li class="nav-item">
                                <a class="nav-link <?= ($mod == 'tabloides' && $ver == 'novo') ? 'active' : ''; ?>" href="sistema.php?mod=tabloides&ver=novo">
                                    <i class="nav-icon icon-plus"></i>Novo</a>
                            </li>                           
                        </ul>
                    </li> 
                    <?php
                }
                if (in_array($core->_vars['user']['ga'], array(1))) {
                    ?>                         
                    <li class="nav-item nav-dropdown <?= ($mod == 'tabloidesap') ? 'open' : ''; ?>">                    
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-note"></i> Tabloides</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link <?= ($mod == 'tabloidesap' && $ver == 'lista') ? 'active' : ''; ?>" href="sistema.php?mod=tabloidesap&ver=lista">
                                    <i class="nav-icon icon-list"></i>Lista</a>
                            </li>                                                     
                        </ul>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link <?= ($mod == 'tabloidesap' && $ver == 'exp') ? 'active' : ''; ?>" href="sistema.php?mod=tabloidesap&ver=exp">
                                    <i class="nav-icon fa fa-file-excel-o"></i>Exportar</a>
                            </li>                                                     
                        </ul>
                    </li> 
                    <?php
                }
                ?>
            </ul>
        </nav>       
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>   
    <aside class="aside-menu">       
        <!-- Tab panes-->
        <div class="tab-content">
            <div class="tab-pane active" id="timeline" role="tabpanel">
                <div class="list-group list-group-accent">
                    <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                        <div>
                            <a class="dropdown-item" href="processa/sair.php"><i class="fa fa-lock"></i>Sair</a>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </aside>
</div>

