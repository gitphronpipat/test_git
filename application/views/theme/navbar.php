<?php $seg = $this->uri->segment(2); ?>

<style>
  .lumiere-navbar {
    background: #fff;
    border-bottom: 0.5px solid rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
  }
  .lumiere-navbar .inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 2rem;
  }
  .lumiere-navbar .brand {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 300;
    letter-spacing: 0.18em;
    color: #1a1a1a;
    text-decoration: none;
    padding: 1rem 0;
  }
  .lumiere-navbar .nav-links { display: flex; }
  .lumiere-navbar .nav-links a {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 1rem 1rem;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #888;
    text-decoration: none;
    border-bottom: 1.5px solid transparent;
    transition: color 0.2s, border-color 0.2s;
  }
  .lumiere-navbar .nav-links a:hover { color: #1a1a1a; }
  .lumiere-navbar .nav-links a.active {
    color: #1a1a1a;
    border-bottom-color: #1a1a1a;
  }
</style>

<nav class="lumiere-navbar">
  <div class="inner">
    <a class="brand" href="<?= base_url('/') ?>">LUMIÈRE</a>
    <div class="nav-links">
      <a href="<?= base_url('welcome') ?>"
         class="<?= ($seg === '' || $seg === false) ? 'active' : '' ?>">
        <i class="bi bi-house"></i> Home
      </a>
      <a href="<?= base_url('welcome/about') ?>"
         class="<?= ($seg === 'about') ? 'active' : '' ?>">
        <i class="bi bi-map"></i> About
      </a>
      <a href="<?= base_url('welcome/reserve') ?>"
         class="<?= ($seg === 'reserve') ? 'active' : '' ?>">
        <i class="bi bi-calendar2-check"></i> Reserve
      </a>
    </div>
  </div>
</nav>
