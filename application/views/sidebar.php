<?php
$session      = $this->session->all_userdata();
$username     = ucwords($session['username']);
$level        = $session['level'];
$level_native = $session['level_native'];
$user_id      = $session['user_id'];

$menu_list = [
    [
        'name' => 'Beranda',
        'url'  => 'home',
        'icon' => 'fa fa-home'
    ],
    [
        'title' => 'Penerbitan'
    ],
    [
        'name' => 'Draft',
        'url'  => 'draft',
        'icon' => 'fa fa-paperclip'
    ],
    [
        'name'  => 'Buku',
        'url'   => 'book',
        'icon'  => 'fa fa-book',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'title' => 'Produksi',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'name' => 'Order Cetak',
        'url'  => 'printing',
        'icon' => 'fa fa-print',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'title' => 'Data',
        'level' => 'superadmin|admin_penerbitan|editor|layouter'
    ],
    [
        'name'  => 'Lembar Kerja',
        'url'   => 'worksheet',
        'icon'  => 'fa fa-pencil-alt',
        'level' => 'superadmin|admin_penerbitan|editor|layouter',
    ],
    [
        'name'  => 'Penulis',
        'url'   => 'author',
        'icon'  => 'fa fa-user-tie',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'name'  => 'Reviewer',
        'url'   => 'reviewer',
        'icon'  => 'fa fa-user-graduate',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'name'  => 'Akun User',
        'url'   => 'user',
        'icon'  => 'fa fa-users',
        'level' => 'superadmin'
    ],
    [
        'name'  => 'Master Data',
        'icon'  => 'fa fa-puzzle-piece',
        'level' => 'superadmin|admin_penerbitan',
        'child' => [
            [
                'name'  => 'Kategori Draft',
                'url'   => 'category',
                'level' => 'superadmin|admin_penerbitan'
            ],
            [
                'name'  => 'Tema Draft',
                'url'   => 'theme',
                'level' => 'superadmin|admin_penerbitan'
            ],
            [
                'name'  => 'Unit Kerja Penulis',
                'url'   => 'work_unit',
                'level' => 'superadmin|admin_penerbitan'
            ],
            [
                'name'  => 'Institusi Penulis',
                'url'   => 'institute',
                'level' => 'superadmin|admin_penerbitan'
            ],
            [
                'name'  => 'Fakultas Reviewer',
                'url'   => 'faculty',
                'level' => 'superadmin|admin_penerbitan'
            ],
        ]
    ],
    [
        'name'  => 'Dokumen',
        'url'   => 'document',
        'icon'  => 'fa fa-file',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'title' => 'Laporan',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'name'  => 'Grafik',
        'url'   => 'reporting',
        'icon'  => 'fa fa-chart-bar',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'name'  => 'Performa Staff',
        'url'   => 'performance',
        'icon'  => 'fa fa-walking',
        'level' => 'superadmin|admin_penerbitan'
    ],
    [
        'title' => 'Sistem',
        'level' => 'superadmin'
    ],
    [
        'name'  => 'Pengaturan',
        'url'   => 'setting',
        'icon'  => 'fa fa-cog',
        'level' => 'superadmin'
    ],
]
?>

<aside class="app-aside app-aside-expand-md app-aside-light">
    <div class="aside-content">
        <header class="aside-header d-block d-md-none">
            <button
                class="btn-account"
                type="button"
                data-toggle="collapse"
                data-target="#dropdown-aside"
            >
                <span class="user-avatar user-avatar-lg">
                    <img src="<?= base_url('assets/images/avatars/profile.jpg'); ?>">
                </span>
                <span class="account-icon">
                    <span class="fa fa-caret-down fa-lg"></span>
                </span>
                <span class="account-summary">
                    <span class="account-name"><?= $username; ?></span>
                    <span class="account-description"><?= ucwords(str_replace('_', ' ', $level)) ?></span>
                </span>
            </button>

            <div
                id="dropdown-aside"
                class="dropdown-aside collapse"
            >
                <div class="pb-3">
                    <?php if ($level_native == 'author_reviewer') : ?>
                        <?php if ($level == 'author') : ?>
                            <a
                                class="dropdown-item"
                                href="<?= base_url('auth/multilevel/reviewer'); ?>"
                            >
                                <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Reviewer</a>
                        <?php else : ?>
                            <a
                                class="dropdown-item"
                                href="<?= base_url('auth/multilevel/author'); ?>"
                            >
                                <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Author</a>
                        <?php endif; ?>
                        <hr>
                    <?php endif; ?>

                    <a
                        class="dropdown-item"
                        href="<?= base_url("auth/change_password/$user_id"); ?>"
                    >
                        <span class="dropdown-icon fa fa-cog"></span> Ganti Password</a>
                    <a
                        class="dropdown-item"
                        href="<?= base_url('auth/logout'); ?>"
                    >
                        <span class="dropdown-icon fa fa-sign-out-alt"></span> Logout</a>
                </div>
            </div>
        </header>

        <div class="aside-menu overflow-hidden">
            <nav
                id="stacked-menu"
                class="stacked-menu"
            >
                <ul class="menu">
                    <?php foreach ($menu_list as $menu) : ?>
                        <?php
                        $level_allowed = isset($menu['level']) ? explode('|', $menu['level']) : [];
                        $is_shown = !isset($menu['level']) || isset($menu['level']) && in_array($level, $level_allowed);
                        ?>
                        <?php if ($is_shown) : ?>
                            <!-- title -->
                            <?php if (isset($menu['title'])) {
                                echo '<li class="menu-header">' . $menu['title'] . '</li>';
                            } ?>

                            <!-- single -->
                            <?php if (isset($menu['name']) && !isset($menu['child'])) : ?>
                                <li class="menu-item <?= ($pages == $menu['url']) ? 'has-active' : ''; ?>">
                                    <a
                                        href="<?= base_url($menu['url']); ?>"
                                        class="menu-link"
                                    >
                                        <span class="menu-icon <?= $menu['icon'] ?>"></span>
                                        <span class="menu-text"><?= $menu['name'] ?></span>
                                    </a>
                                </li>
                            <?php endif ?>

                            <!-- nested -->
                            <?php if (isset($menu['name']) && isset($menu['child'])) : ?>
                                <?php $child_pages = array_map(function ($child) {
                                    return $child['url'];
                                }, $menu['child']) ?>
                                <li class="menu-item has-child <?= in_array($pages, $child_pages) ? 'has-active' : ''; ?>">
                                    <a
                                        href="#"
                                        class="menu-link"
                                    >
                                        <span class="menu-icon <?= $menu['icon'] ?>"></span>
                                        <span class="menu-text"><?= $menu['name'] ?></span>
                                    </a>
                                    <ul class="menu">
                                        <?php foreach ($menu['child'] as $child) : ?>
                                            <li class="menu-item <?= ($pages == $child['url']) ? 'has-active' : ''; ?>">
                                                <a
                                                    href="<?= base_url($child['url']); ?>"
                                                    class="menu-link"
                                                ><?= $child['name'] ?></a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </li>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </nav>
        </div>

        <footer class="aside-footer border-top p-3">
            <button
                class="btn btn-light btn-block text-primary"
                data-toggle="skin"
            >Night mode <i class="fas fa-moon ml-1"></i></button>
        </footer>
    </div>
</aside>
