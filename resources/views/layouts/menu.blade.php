<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        /* Professional Color Palette - Muted & Sophisticated */
        --gradient-slate: linear-gradient(135deg, #4A5568 0%, #2D3748 100%);
        --gradient-navy: linear-gradient(135deg, #2C5282 0%, #1A365D 100%);
        --gradient-teal: linear-gradient(135deg, #319795 0%, #285E61 100%);
        --gradient-emerald: linear-gradient(135deg, #38A169 0%, #276749 100%);
        --gradient-amber: linear-gradient(135deg, #D69E2E 0%, #975A16 100%);
        --gradient-purple: linear-gradient(135deg, #6B46C1 0%, #553C9A 100%);
        --gradient-rose: linear-gradient(135deg, #E53E3E 0%, #9B2C2C 100%);
        --gradient-cyan: linear-gradient(135deg, #0987A0 0%, #086F83 100%);
        --gradient-indigo: linear-gradient(135deg, #5A67D8 0%, #434190 100%);
        --gradient-gray: linear-gradient(135deg, #718096 0%, #4A5568 100%);

        /* Accent Colors - More Subtle */
        --accent-slate: #4A5568;
        --accent-navy: #2C5282;
        --accent-teal: #319795;
        --accent-emerald: #38A169;
        --accent-amber: #D69E2E;
        --accent-purple: #6B46C1;
        --accent-rose: #E53E3E;
        --accent-cyan: #0987A0;
        --accent-indigo: #5A67D8;
        --accent-gray: #718096;
    }

    /* CRITICAL: Main content wrapper padding */
    .m-wrapper {
        padding-top: 120px !important;
    }

    /* Top Navigation Bar Container */
    #sticky-header {
        position: fixed !important;
        top: 60px;
        left: 0;
        right: 0;
        width: 100%;
        background: transparent;
        z-index: 999;
    }

    .modern-top-nav {
        /*background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);*/
        /* background: linear-gradient(135deg, #005762 0%, #026976 100%); */
        background: linear-gradient(135deg, #05244f 0%, #05244f 100%);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        position: relative;
        z-index: 1001;
    }

    .modern-main-menu {
        display: flex;
        list-style: none;
        align-items: center;
        padding: 0;
        margin: 0;
        max-width: 100%;
        overflow-x: auto;
    }

    .modern-main-menu::-webkit-scrollbar {
        height: 4px;
    }

    .modern-main-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .modern-main-menu>li {
        position: relative;
        flex-shrink: 0;
    }

    .modern-main-menu>li>a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 22px;
        color: rgba(255, 255, 255, 0.95);
        text-decoration: none;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
        white-space: nowrap;
    }

    .modern-main-menu>li>a:hover {
        background: rgba(255, 255, 255, 0.12);
        color: white;
    }

    .modern-main-menu>li.menu-active>a {
        background: rgba(255, 255, 255, 0.18);
        color: white;
    }

    .modern-main-menu>li>a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.3s ease;
    }

    .modern-main-menu>li:hover>a::after,
    .modern-main-menu>li.menu-active>a::after {
        width: 70%;
    }

    .modern-main-menu>li>a i.fa-chevron-down {
        font-size: 9px;
        margin-left: 4px;
        transition: transform 0.3s ease;
    }

    .modern-main-menu>li.menu-active>a i.fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Mega Menu Container */
    .bright-mega-container {
        position: fixed !important;
        top: 116px !important;
        left: 0 !important;
        right: 0 !important;
        width: 100vw !important;
        background: #f8fafc;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        max-height: calc(100vh - 116px);
        overflow-y: auto;
        z-index: 998 !important;
        display: none;
    }

    .bright-mega-container.active {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        display: block !important;
    }

    .bright-mega-content {
        padding: 28px 20px;
        max-width: 100%;
        margin: 0 auto;
    }

    /* Masonry Grid Layout */
    .bright-menu-masonry {
        display: flex;
        gap: 18px;
        align-items: flex-start;
    }

    .masonry-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-width: 0;
    }

    /* Menu Card - Professional Design */
    .bright-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        animation: brightFadeIn 0.5s ease forwards;
        opacity: 0;
        break-inside: avoid;
        border: 1px solid #e2e8f0;
    }

    .bright-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e0;
    }

    @keyframes brightFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Header - Professional Colors */
    .bright-card-header {
        padding: 14px 18px;
        color: white;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: default;
        position: relative;
    }

    .bright-card-header i {
        font-size: 14px;
        opacity: 0.95;
    }

    /* Card Body */
    .bright-card-body {
        padding: 0;
        background: white;
    }

    .bright-card-body ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .bright-card-body li {
        border-bottom: 1px solid #f1f5f9;
    }

    .bright-card-body li:last-child {
        border-bottom: none;
    }

    .bright-card-body li a {
        display: flex;
        align-items: center;
        padding: 11px 18px;
        color: #334155;
        text-decoration: none;
        font-size: 13px;
        font-weight: 400;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .bright-card-body li a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--card-accent, #4A5568);
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }

    .bright-card-body li a:hover {
        background: linear-gradient(90deg, rgba(148, 163, 184, 0.08), transparent);
        padding-left: 24px;
        color: #1e293b;
    }

    .bright-card-body li a:hover::before {
        transform: scaleY(1);
    }

    .bright-card-body li a i.menu-icon {
        margin-right: 10px;
        font-size: 13px;
        width: 20px;
        text-align: center;
        opacity: 0.85;
        flex-shrink: 0;
        /* Prevent icon from shrinking */
    }

    .bright-card-body li a:hover i.menu-icon {
        opacity: 1;
    }

    .bright-card-body li a .fa-plus-circle {
        /* margin-left: auto; */
        color: #10b981;
        font-size: 15px;
        opacity: 0.6;
        transition: all 0.2s ease;
    }

    .bright-card-body li a:hover .fa-plus-circle {
        opacity: 1;
        transform: scale(1.15);
    }

    /* Current page highlight */
    .bright-card-body li a.current-page {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.12), transparent);
        font-weight: 600;
        color: var(--card-accent);
    }

    .bright-card-body li a.current-page::before {
        transform: scaleY(1);
    }

    .bright-card-body li a.current-page i.menu-icon {
        opacity: 1;
    }

    /* Responsive */
    @media (min-width: 1600px) {
        .masonry-column {
            flex: 0 0 calc(16.666% - 15px);
            /* 6 columns */
        }
    }

    @media (min-width: 1200px) and (max-width: 1599px) {
        .masonry-column {
            flex: 0 0 calc(20% - 14.4px);
            /* 5 columns */
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .masonry-column {
            flex: 0 0 calc(25% - 13.5px);
            /* 4 columns */
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .masonry-column {
            flex: 0 0 calc(33.333% - 12px);
            /* 3 columns */
        }
    }

    @media (max-width: 767px) {
        .masonry-column {
            flex: 0 0 calc(50% - 9px);
            /* 2 columns */
        }

        .bright-mega-content {
            padding: 18px 10px;
        }

        .modern-main-menu>li>a {
            padding: 13px 15px;
            font-size: 12px;
        }

        .m-wrapper {
            padding-top: 110px !important;
        }
    }

    @media (max-width: 480px) {
        .masonry-column {
            flex: 0 0 100%;
            /* 1 column */
        }

        .bright-mega-content {
            padding: 15px 10px;
        }
    }

    /* Scrollbar */
    .bright-mega-container::-webkit-scrollbar {
        width: 8px;
    }

    .bright-mega-container::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .bright-mega-container::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 4px;
    }

    .bright-mega-container::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* Stagger animation for cards */
    .bright-card {
        animation-delay: calc(var(--card-index) * 0.04s);
    }

    /* Loading state */
    .bright-card.loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Empty state */
    .bright-card-empty {
        padding: 24px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
    }
</style>

<nav class="modern-top-nav">
    <ul class="modern-main-menu">
        <?php
$headers = DB::table("tb_menus")->select('*')->where('parent_id', '=', 0)->orderBy('menus_id', 'asc')->get();

$access = \DB::table('a_user_access_t')->select('*')->where('user_id', \Session::get('id'))->get();
$access = json_decode($access[0]->menus);

$group_id = \DB::table('a_user_access_t')->select('group_id')->where('user_id', \Session::get('id'))->get();
$group_id = json_decode($group_id[0]->group_id);

$subsubmenu = array();
$controllers = array();
$controller = array();
$createurl = array();
$menuIcons = array();
$submenuIcons = array();

foreach ($headers as $key => $value) {
    $subsubmenu[$value->menus_id] = array();
    $controller[$value->menus_id] = $value->controller_name;
    $controllers[$value->menus_id] = array();
    $createurl[$value->menus_id] = array();
    $menuIcons[$value->menus_id] = array();
    $submenuIcons[$value->menus_id] = array();

    $subhead = DB::table("tb_menus")->select('*')->where('parent_id', '=', $value->menus_id)->orderBy('menus_id', 'asc')->get();
    // dd($subhead);
    foreach ($subhead as $k => $v) {
        $subsubmenu[$value->menus_id][$v->menus_id] = array();
        $menuIcons[$value->menus_id][$v->menus_id] = $v->icon ?? 'fa-solid fa-folder';
        $submenuIcons[$value->menus_id][$v->menus_id] = array();

        $subname = DB::table("tb_menus")->select('*')->where('parent_id', '=', $v->menus_id)->orderBy('menus_id', 'asc')->get();
        // dd($subname);
        foreach ($subname as $k1 => $v1) {
            $subsubmenu[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->menus_name;
            $controllers[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->controller_name;
            $createurl[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->createurl;
            $menuIcons[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->icon ?? 'fa-solid fa-circle';
            $submenuIcons[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->icon ?? 'fa-solid fa-circle';
        }
    }
}
        ?>

        <?php foreach ($subsubmenu as $key => $value) {
    if (isset($access->$key)) {
        $name = DB::table("tb_menus")->select('*')->where('menus_id', '=', $key)->get();
        $menuName = $name[0]->menus_name;
        $menuIcon = $name[0]->icon ?? 'fa-solid fa-folder';
        $menuId = 'menu-' . $key;
        ?>
        <li class="menu-parent-<?php        echo $key; ?>">
            <a href="javascript:void(0)"
                onclick="toggleBrightMenu('<?php        echo $menuId; ?>', this); return false;">
                <i class="<?php        echo $menuIcon; ?>"></i>
                <?php        echo $menuName; ?>
                <i class="fa-solid fa-chevron-down"></i>
            </a>

            <div class="bright-mega-container" id="<?php        echo $menuId; ?>">
                <div class="bright-mega-content">
                    <div class="bright-menu-masonry" id="masonry-<?php        echo $menuId; ?>">
                        <!-- Masonry columns will be created dynamically -->
                    </div>
                </div>
            </div>
        </li>
        <?php    }
} ?>
    </ul>
</nav>
<script>
    let currentOpenMenu = null;
    let menuData = {};

    // Store menu data in JavaScript
    <?php foreach ($subsubmenu as $key => $value) {
    if (isset($access->$key)) {
        $menuId = 'menu-' . $key;
?>
    menuData['<?php        echo $menuId; ?>'] = [
        <?php 
    $cardIndex = 0;
        foreach ($value as $k => $v) {
            if (isset($access->$k) && !empty($v)) {
                $name1 = DB::table("tb_menus")->select('*')->where('menus_id', '=', $k)->get();
                $cardIndex++;
    ?> {
            title: <?php                echo json_encode($name1[0]->menus_name); ?>,
            icon: <?php                echo json_encode($menuIcons[$key][$k]); ?>,
            items: [
                <?php 
            foreach ($v as $k1 => $v1) {
                    if (isset($access->$k1)) {
                        $menuItem = DB::table("tb_menus")->select('*')->where('menus_id', '=', $k1)->first();
                        $isCurrentPage = Request::is($menuItem->controller_name) ? 'true' : 'false';
                        // CRITICAL FIX: Use json_encode to properly escape icon string
                        $menuIcon = $submenuIcons[$key][$k][$k1];
                        //  dd($menuIcons[$key]);
            ?> {
                    name: <?php                        echo json_encode($v1); ?>,
                    icon: <?php                        echo json_encode($menuIcon); ?>,
                    url: <?php                        echo json_encode(URL::to($controllers[$key][$k][$k1])); ?>,
                    createUrl: <?php                        echo json_encode(isset($createurl[$key][$k][$k1]) ? URL::to($createurl[$key][$k][$k1]) : ''); ?>,
                    isCurrent: <?php                        echo $isCurrentPage; ?>
                },
                <?php                    }
                } ?>
            ]
        },
        <?php            }
        } ?>
    ];
    <?php    }
} ?>

    function toggleBrightMenu(menuId, element) {
        const menuContainer = document.getElementById(menuId);
        const parentLi = element.closest('li');

        if (!menuContainer) return;

        if (currentOpenMenu === menuId) {
            menuContainer.classList.remove('active');
            parentLi.classList.remove('menu-active');
            currentOpenMenu = null;
            return;
        }

        document.querySelectorAll('.bright-mega-container').forEach(menu => {
            menu.classList.remove('active');
        });
        document.querySelectorAll('.modern-main-menu > li').forEach(li => {
            li.classList.remove('menu-active');
        });

        menuContainer.classList.add('active');
        parentLi.classList.add('menu-active');
        currentOpenMenu = menuId;

        buildMasonryLayout('masonry-' + menuId, menuData[menuId]);
    }

    function buildMasonryLayout(containerId, cards) {
        const container = document.getElementById(containerId);
        if (!container || !cards) return;

        container.innerHTML = '';

        const screenWidth = window.innerWidth;
        let columnCount;
        if (screenWidth >= 1600) columnCount = 6;
        else if (screenWidth >= 1200) columnCount = 5;
        else if (screenWidth >= 992) columnCount = 4;
        else if (screenWidth >= 768) columnCount = 3;
        else if (screenWidth >= 480) columnCount = 2;
        else columnCount = 1;

        const columns = [];
        for (let i = 0; i < columnCount; i++) {
            const column = document.createElement('div');
            column.className = 'masonry-column';
            columns.push(column);
            container.appendChild(column);
        }

        const columnHeights = new Array(columnCount).fill(0);
        // console.log(cards);
        cards.forEach((cardData, index) => {
            const shortestColumnIndex = columnHeights.indexOf(Math.min(...columnHeights));
            const card = createCard(cardData, index);
            columns[shortestColumnIndex].appendChild(card);
            const itemCount = cardData.items.length;
            columnHeights[shortestColumnIndex] += 60 + (itemCount * 45);
        });
    }

    function createCard(cardData, index) {
        // console.log(cardData);
        const card = document.createElement('div');
        card.className = 'bright-card';
        card.style.setProperty('--card-index', index);

        const gradients = [
            'linear-gradient(135deg, #4A5568 0%, #2D3748 100%)',
            'linear-gradient(135deg, #2C5282 0%, #1A365D 100%)',
            'linear-gradient(135deg, #319795 0%, #285E61 100%)',
            'linear-gradient(135deg, #38A169 0%, #276749 100%)',
            'linear-gradient(135deg, #D69E2E 0%, #975A16 100%)',
            'linear-gradient(135deg, #6B46C1 0%, #553C9A 100%)',
            'linear-gradient(135deg, #E53E3E 0%, #9B2C2C 100%)',
            'linear-gradient(135deg, #0987A0 0%, #086F83 100%)',
            'linear-gradient(135deg, #5A67D8 0%, #434190 100%)',
            'linear-gradient(135deg, #718096 0%, #4A5568 100%)'
        ];

        const accentColors = [
            '#4A5568', '#2C5282', '#319795', '#38A169', '#D69E2E',
            '#6B46C1', '#E53E3E', '#0987A0', '#5A67D8', '#718096'
        ];

        const colorIndex = index % gradients.length;
        card.style.setProperty('--card-accent', accentColors[colorIndex]);

        const header = document.createElement('div');
        header.className = 'bright-card-header';
        header.style.background = gradients[colorIndex];
        header.innerHTML = `<i class="${cardData.icon || 'fa-solid fa-folder'}"></i> ${cardData.title}`;

        const body = document.createElement('div');
        body.className = 'bright-card-body';

        const ul = document.createElement('ul');
        cardData.items.forEach(item => {
            const li = document.createElement('li');
            const currentClass = item.isCurrent ? 'current-page' : '';

            // Validate and clean icon
            let iconClass = 'fa-solid fa-circle'; // default

            if (item.icon) {
                const cleanIcon = String(item.icon).trim();
                if (cleanIcon && cleanIcon.length > 3) {
                    iconClass = cleanIcon;
                } else {
                    console.warn('Invalid icon for:', item.name, 'Got:', item.icon);
                }
            }

            li.innerHTML = `
            <a href="${item.url}" class="${currentClass}">
                <i class="${iconClass} menu-icon" style="color: ${accentColors[colorIndex]}"></i>
                <span>${item.name}</span>
            </a>
        `;
            ul.appendChild(li);
        });

        body.appendChild(ul);
        card.appendChild(header);
        card.appendChild(body);

        return card;
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.modern-main-menu') && currentOpenMenu) {
            document.querySelectorAll('.bright-mega-container').forEach(menu => {
                menu.classList.remove('active');
            });
            document.querySelectorAll('.modern-main-menu > li').forEach(li => {
                li.classList.remove('menu-active');
            });
            currentOpenMenu = null;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && currentOpenMenu) {
            document.querySelectorAll('.bright-mega-container').forEach(menu => {
                menu.classList.remove('active');
            });
            document.querySelectorAll('.modern-main-menu > li').forEach(li => {
                li.classList.remove('menu-active');
            });
            currentOpenMenu = null;
        }
    });

    document.querySelectorAll('.bright-mega-container').forEach(menu => {
        menu.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });

    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            if (currentOpenMenu) {
                buildMasonryLayout('masonry-' + currentOpenMenu, menuData[currentOpenMenu]);
            }
        }, 250);
    });

    // Debug logging
    console.log('=== MENU DEBUG ===');
    console.log('Total menus:', Object.keys(menuData).length);
    Object.keys(menuData).forEach(menuKey => {
        const menu = menuData[menuKey];
        console.log(`Menu: ${menuKey}, Cards: ${menu.length}`);
        menu.forEach((card, idx) => {
            console.log(`  Card ${idx}: ${card.title}, Icon: ${card.icon}`);
            card.items.slice(0, 3).forEach(item => {
                console.log(`    - ${item.name}: ${item.icon}`);
            });
        });
    });
</script>