<style>
  .lumiere-sidebar {
    position: fixed;
    top: 57px; left: 0;
    width: 200px;
    height: calc(100vh - 57px);
    background: #fafafa;
    border-right: 0.5px solid rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    padding: 1.5rem 0;
    z-index: 900;
    overflow-y: auto;
  }
  .lumiere-sidebar .group-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1.5rem;
    font-family: 'Lato', sans-serif;
    font-size: 10px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #aaa;
    cursor: pointer;
    user-select: none;
    transition: color 0.2s;
  }
  .lumiere-sidebar .group-toggle:hover { color: #1a1a1a; }
  .lumiere-sidebar .group-toggle .arrow { transition: transform 0.3s; }
  .lumiere-sidebar .group-toggle.open   .arrow { transform: rotate(180deg); }
  .lumiere-sidebar .group-items {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease;
  }
  .lumiere-sidebar .group-items.open { max-height: 500px; }
  .lumiere-sidebar .group-items a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.65rem 1.5rem 0.65rem 2rem;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #999;
    text-decoration: none;
    border-left: 1.5px solid transparent;
    transition: color 0.2s, border-color 0.2s, background 0.2s;
  }
  .lumiere-sidebar .group-items a:hover  { color: #1a1a1a; background: rgba(0,0,0,0.03); }
  .lumiere-sidebar .group-items a.active { color: #1a1a1a; border-left-color: #1a1a1a; background: rgba(0,0,0,0.03); }
  .lumiere-sidebar .group-direct {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.75rem 1.5rem;
    font-family: 'Lato', sans-serif;
    font-size: 10px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #aaa;
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
  }
  .lumiere-sidebar .group-direct:hover  { color: #1a1a1a; background: rgba(0,0,0,0.03); }
  .lumiere-sidebar .group-direct.active { color: #1a1a1a; background: rgba(0,0,0,0.03); }
  .lumiere-sidebar .sep { height: 0.5px; background: rgba(0,0,0,0.08); margin: 0.5rem 1.5rem; }
  #main { margin-left: 200px; }
</style>

<?php
$cat    = $this->input->get('cat');
$groups = [
    [
        'slug'       => 'home',
        'label'      => 'หน้าหลัก',
        'icon'       => '<i class="fas fa-house"></i>',
        'url'        => base_url('index.php/welcome/'),
        'controller' => 'welcome',
        'method'     => 'index',
    ],
    [
        'slug'    => 'food',
        'label'   => 'อาหาร',
        'icon'    => '<i class="fas fa-egg"></i>',
        'submenu' => [
            ['slug' => 'starters', 'label' => 'Starters',    'icon' => '<i class="fas fa-egg"></i>',       'url' => base_url('welcome/menu')],
            ['slug' => 'mains',    'label' => 'Main Course',  'icon' => '<i class="fas fa-fire"></i>',      'url' => base_url('welcome/menu?cat=mains')],
            ['slug' => 'desserts', 'label' => 'Desserts',     'icon' => '<i class="fas fa-ice-cream"></i>', 'url' => base_url('welcome/menu?cat=desserts')],
        ],
    ],
    [
        'slug'    => 'drinks',
        'label'   => 'เครื่องดื่ม',
        'icon'    => '<i class="fas fa-wine-glass"></i>',
        'submenu' => [
            ['slug' => 'drinks', 'label' => 'Beverages', 'icon' => '<i class="fas fa-martini-glass"></i>', 'url' => base_url('welcome/menu?cat=drinks')],
        ],
    ],
];

// หา active_group_slug จาก ?cat= ใน URL
$active_group_slug = '';
foreach ($groups as $group) {
    if (isset($group['submenu'])) {
        foreach ($group['submenu'] as $item) {
            if ($item['slug'] === $cat) {
                $active_group_slug = $group['slug'];
                break 2;
            }
        }
    }
}

// fallback → ถ้าหาไม่เจอให้ชี้ไป group แรก แต่ไม่ set $cat
if (!$active_group_slug) {
    $active_group_slug = $groups[0]['slug'];
}
?>

<div class="lumiere-sidebar">
  <?php $first = true; foreach ($groups as $group):
    $has_sub  = isset($group['submenu']) && !empty($group['submenu']);
    $is_open  = ($active_group_slug === $group['slug']);
  ?>

    <?php if (!$first): ?><div class="sep"></div><?php endif; $first = false; ?>

    <?php if ($has_sub): ?>

      <!-- มี submenu → accordion -->
      <div class="group-toggle <?= $is_open ? 'open' : '' ?>" data-target="grp-<?= $group['slug'] ?>">
        <span><?= $group['icon'] ?> <?= $group['label'] ?></span>
        <i class="fas fa-chevron-down arrow"></i>
      </div>
      <div class="group-items <?= $is_open ? 'open' : '' ?>" id="grp-<?= $group['slug'] ?>">
        <?php foreach ($group['submenu'] as $item): ?>
          <a href="<?= $item['url'] ?>" class="<?= ($cat === $item['slug']) ? 'active' : '' ?>">
            <?= $item['icon'] ?> <?= $item['label'] ?>
          </a>
        <?php endforeach; ?>
      </div>

    <?php else: ?>

      <!-- ไม่มี submenu → direct link เช็ค active จาก controller/method -->
      <?php
        $is_active = (
            $this->router->fetch_class() === ($group['controller'] ?? '') &&
            $this->router->fetch_method() === ($group['method'] ?? '')
        );
      ?>
      <a href="<?= $group['url'] ?>" class="group-direct <?= $is_active ? 'active' : '' ?>">
        <?= $group['icon'] ?> <?= $group['label'] ?>
      </a>

    <?php endif; ?>

  <?php endforeach; ?>
</div>

<script>
  document.querySelectorAll('.lumiere-sidebar .group-toggle').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
      var items  = document.getElementById(this.dataset.target);
      var isOpen = items.classList.contains('open');

      document.querySelectorAll('.lumiere-sidebar .group-items, .lumiere-sidebar .group-toggle')
              .forEach(el => el.classList.remove('open'));

      if (!isOpen) {
        items.classList.add('open');
        this.classList.add('open');
      }
    });
  });
</script>
