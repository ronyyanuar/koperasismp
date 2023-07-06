<div class="sidebar-body">
    <ul class="sidebar-body-menu">
        <li>
            <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/index.php') echo 'class="active"'; ?> href="/koperasi/admin/index.php">
                <span class="icon home" aria-hidden="true"></span>Dashboard
            </a>
        </li>
        <li>
            <a class="show-cat-btn <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/order.php' || $_SERVER['REQUEST_URI'] == '/koperasi/admin/order-pending.php'|| $_SERVER['REQUEST_URI'] == '/koperasi/admin/order-send.php') echo 'active'; ?>" href="##">
                <span class="icon document" aria-hidden="true"></span>Orders
                <span class="category__btn transparent-btn" title="Open list">
                    <span class="sr-only">Open list</span>
                    <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
            </a>
            <ul class="cat-sub-menu">
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/order.php') echo 'class="active"'; ?> href="order.php">Semua Order</a>
                </li>
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/order-pending.php') echo 'class="active"'; ?> href="order-pending.php">Order Tertunda</a>
                </li>
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/order-send.php') echo 'class="active"'; ?> href="order-send.php">Harus Dikirim</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="show-cat-btn <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/penjualan.php') echo 'active'; ?>" href="##">
                <span class="icon folder" aria-hidden="true"></span>Penjualan
                <span class="category__btn transparent-btn" title="Open list">
                    <span class="sr-only">Open list</span>
                    <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
            </a>
            <ul class="cat-sub-menu">
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/penjualan.php') echo 'class="active"'; ?> href="penjualan.php">Data Penjualan</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="show-cat-btn <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/produk.php' || $_SERVER['REQUEST_URI'] == '/koperasi/admin/produk-add.php' || $_SERVER['REQUEST_URI'] == '/koperasi/admin/produk-edit.php') echo 'active'; ?>" href="##">
                <span class="icon paper" aria-hidden="true"></span>Produk
                <span class="category__btn transparent-btn" title="Open list">
                    <span class="sr-only">Open list</span>
                    <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
            </a>
            <ul class="cat-sub-menu">
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/produk.php') echo 'class="active"'; ?> href="produk.php">Daftar Produk</a>
                </li>
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/produk-add.php') echo 'class="active"'; ?> href="produk-add.php">Input Produk</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="show-cat-btn <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/siswa.php' || $_SERVER['REQUEST_URI'] == '/koperasi/admin/siswa-add.php' || $_SERVER['REQUEST_URI'] == '/koperasi/admin/siswa-edit.php') echo 'active'; ?>" href="##">
                <span class="icon user-3" aria-hidden="true"></span>Siswa
                <span class="category__btn transparent-btn" title="Open list">
                    <span class="sr-only">Open list</span>
                    <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
            </a>
            <ul class="cat-sub-menu">
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/user.php') echo 'class="active"'; ?> href="siswa.php">Data Siswa</a>
                </li>
                <li>
                    <a <?php if ($_SERVER['REQUEST_URI'] == '/koperasi/admin/siswa-add.php') echo 'class="active"'; ?> href="siswa-add.php">Input Siswa</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
