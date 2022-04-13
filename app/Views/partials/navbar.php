<?php // handle last login time
if(session()->get('lastLogin')!=null) {
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('Europe/Ljubljana'));
    $date->setTimestamp(session()->get('lastLogin'));
}
?>

<nav class="fixed-top">
    <ul class="navbar navbar-dark bg-dark mb-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/projekti"><b>SMRPO</b></a>
            <span class="navbar-text"><?php if (session()->get('lastLogin') != null) echo $date->format('d.m.Y H:i:s') ;
                else echo "To je vaša prva prijava";     ?></span>
            <ul class="nav nav-justify-content-end">
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo session()->get('username')?>
                        <?php if (session()->get('permissions') == 0) {
                            echo '(admin)';
                        } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/profile">Profil</a>
                        </li>
                        <?php if (session()->get('permissions') == 0) { ?>
                            <li>
                                <a class="dropdown-item" href="/admin/createUser">Dodaj uporabnika</a>
                            </li>
                        <?php } ?>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="/odjava">Odjava</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </ul>
<?php // only show this part if we're in a project
    if (session()->get('projectId') != null) { ?>
        <ul class="navbar navbar-light bg-secondary mt-0">
            <div class="container-fluid justify-content-start">
                <span class="navbar-brand"><?php echo session()->get('projectName') ?></span>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="Pbacklog"><b>Seznam zahtev</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="Sbacklog"><b>Sprint</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="MyTasks"><b>Moje zgodbe</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"><b>Burn-Down</b></a>
                    </li>
                </ul>
            </div>
        </ul>
<?php   }
    ?>
</nav>




