@foreach($menus as $menu)
    @if(count($menu->children))
        <li>
            <a class="<?= $menu->isActive() ? 'active' : null ?>" href="<?= $menu->full_url ?>"><i class="<?= $menu-> class ?>"></i> <?= $menu->name ?> <span class="fa arrow"></span></a>
            <ul class="nav nav-<?= isset($level) ? Lang::get("gadgets.menus.ordinal.{$level}") : 'second' ?>-level">
                <?= View::make('admin.gadgets.side-menu', ['menus' => $menu->children, 'level' => 3]) ?>
            </ul>
            <!-- /.nav-second-level -->
        </li>
    @else
        <li>
            <a class="<?= $menu->isActive() ? 'active' : null ?>" href="<?= $menu->full_url ?>"><i class="<?= $menu-> class ?>"></i> <?= $menu->name ?></a>
        </li>
    @endif
@endforeach
