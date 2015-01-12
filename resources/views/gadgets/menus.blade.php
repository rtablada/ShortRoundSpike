@foreach($menus as $menu)
    @if(count($menu->children))
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="<?= $menu->class ?>"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <?= View::make('gadgets.menus', ['menus' => $menu->children]) ?>
            </ul>
        </li>
    @else
        <li>
            <a class="<?= $menu->isActive() ? 'active' : null ?>" href="<?= $menu->full_url ?>">
                <i class="<?= $menu-> class ?>"></i> <?= $menu->name ?>
            </a>
        </li>
    @endif
@endforeach
