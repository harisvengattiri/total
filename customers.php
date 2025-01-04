<?php require_once "includes/menu.php"; ?>
<?php 
    $status = getStatusFromUrl();
?>
<div class="app-body">
    <div class="app-body-inner">
        <div class="row-col">
            <div class="white bg b-b"><?php if ($status == "success") { ?>
                    <a class="list-group-item b-l-success">
                        <span class="pull-right text-success"><i class="fa fa-circle text-xs"></i></span>
                        <span class="label rounded label success pos-rlt m-r-xs">
                            <b class="arrow right b-success pull-in"></b><i class="ion-checkmark"></i></span>
                        <span class="text-success">Your Submission was Successfull!</span>
                    </a>
                <?php } else if ($status == "failed") { ?>
                    <a class="list-group-item b-l-danger">
                        <span class="pull-right text-danger"><i class="fa fa-circle text-xs"></i></span>
                        <span class="label rounded label danger pos-rlt m-r-xs">
                            <b class="arrow right b-danger pull-in"></b><i class="ion-checkmark"></i></span>
                        <span class="text-danger">Your Submission was Failed!</span>
                    </a>
                <?php } else if ($status == "deleted") { ?>
                    <a class="list-group-item b-l-warning">
                        <span class="pull-right text-warning"><i class="fa fa-circle text-xs"></i></span>
                        <span class="label rounded label warning pos-rlt m-r-xs">
                            <b class="arrow right b-warning pull-in"></b><i class="ion-checkmark"></i></span>
                        <span class="text-warning">Your Deletion was Successfull!</span>
                    </a>
                <?php } ?>
                <div class="navbar no-radius box-shadow-z1">
                    <a data-toggle="modal" data-target="#subnav" data-ui-modal class="navbar-item pull-left hidden-lg-up">
                        <span class="btn btn-sm btn-icon info">
                            <i class="fa fa-th"></i>
                        </span>
                    </a>
                    <a data-toggle="modal" data-target="#list" data-ui-modal class="navbar-item pull-left hidden-md-up">
                        <span class="btn btn-sm btn-icon white">
                            <i class="fa fa-list"></i>
                        </span>
                    </a>
                    <!-- link and dropdown -->
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <span class="navbar-item text-md">Contacts</span>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASEURL; ?>/add/customer" class="nav-link text-muted" title="Reply">
                                <span class="">
                                    <i class="fa fa-fw fa-plus"></i>
                                    <span class="hidden-sm-down">New contact</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="_blank" href="<?php echo CDNURL; ?>/reports/contacts" class="nav-link text-muted" title="Reply">
                                <span class="">
                                    <i class="fa fa-print"></i>
                                    <span class="hidden-sm-down">Print contact's</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <!-- / link and dropdown -->
                </div>

            </div>
            <div class="row-row">
                <div class="row-col">
                    <div class="col-xs w modal fade aside aside-md b-r" id="subnav">
                        <div class="row-col light bg">
                            <!-- flex content -->
                            <div class="row-row">
                                <div class="row-body scrollable hover">
                                    <div class="row-inner">

                                        <?php
                                        $sql = "SELECT count(*) as total from customers";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Company'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_com = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Individual'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_ind = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Partner'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_par = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Staff'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_sta = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Supplier'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_sup = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='SalesRep'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_srp = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Operator'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_opr = $row['total'];
                                            }
                                        }

                                        $sql = "SELECT count(*) as total from customers where type='Driver'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_drv = $row['total'];
                                            }
                                        }


                                        if (isset($_GET['type'])) {
                                            $type = $_GET['type'];
                                            $sql = "SELECT id,name,email FROM customers where type='$type' ORDER BY name ASC";
                                        } else {
                                            $sql = "SELECT id,name,email FROM customers ORDER BY id DESC LIMIT 0,100";
                                        }
                                        $result = mysqli_query($conn, $sql);
                                        ?>
                                        <!-- content -->
                                        <script>
                                            function contact_type(type) {
                                                $.ajax({

                                                    type: "GET",
                                                    url: 'api/contact.php',
                                                    data: "type=" + type,
                                                    success: function(data) {
                                                        // data is ur summary
                                                        $('#contactlist').html(data);
                                                    }

                                                });

                                            }

                                            function contact_tag(tag) {
                                                $.ajax({

                                                    type: "GET",
                                                    url: 'api/contact.php',
                                                    data: "tag=" + tag,
                                                    success: function(data) {
                                                        // data is ur summary
                                                        $('#contactlist').html(data);
                                                    }

                                                });

                                            }
                                        </script>
                                        <script type="text/javascript">
                                            function cname(value) {
                                                $.post("api/contact.php", {
                                                    cname: value
                                                }, function(data) {
                                                    $("#contactlist").html(data);
                                                });
                                            }
                                        </script>
                                        <div class="navside m-t">
                                            <input class="md-input" type="text" placeholder="&nbsp;&nbsp;Search Contacts" onkeyup="cname(this.value)">
                                            <nav class="nav-border b-primary" data-ui-nav>
                                                <ul class="nav">
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('')">
                                                            <span class="nav-label">
                                                                <b class="label blue-grey rounded">
                                                                    <?php echo $total; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">All</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('Company')">
                                                            <span class="nav-label">
                                                                <b class="label danger rounded">
                                                                    <?php echo $total_com; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Companies</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('Individual')">
                                                            <span class="nav-label">
                                                                <b class="label warn rounded">
                                                                    <?php echo $total_ind; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Individuals</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('Partner')">
                                                            <span class="nav-label">
                                                                <b class="label success rounded">
                                                                    <?php echo $total_par; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Partners</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('Supplier')">
                                                            <span class="nav-label">
                                                                <b class="label warning text-white rounded">
                                                                    <?php echo $total_sup; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Suppliers</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('Staff')">
                                                            <span class="nav-label">
                                                                <b class="label info rounded">
                                                                    <?php echo $total_sta; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Staff</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('salesrep')">
                                                            <span class="nav-label">
                                                                <b class="label info rounded">
                                                                    <?php echo $total_srp; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Sales Rep</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('operator')">
                                                            <span class="nav-label">
                                                                <b class="label info rounded">
                                                                    <?php echo $total_opr; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Operators</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="contact_type('driver')">
                                                            <span class="nav-label">
                                                                <b class="label info rounded">
                                                                    <?php echo $total_drv; ?>
                                                                </b>
                                                            </span>
                                                            <span class="nav-text">Drivers</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / -->
                            <!-- footer -->
                            <!-- <div class="p-a b-t">
                                <a href="<?php // echo BASEURL; ?>/settings" class="btn btn-xs rounded primary"><i class="fa fa-plus m-r-xs"></i>Add New Tag</a>
                            </div> -->
                            <!-- / -->
                        </div>
                    </div>

                    <script>
                        function getcontact(id) {
                            $.ajax({

                                type: "GET",
                                url: 'api/contact.php',
                                data: "id=" + id,
                                success: function(data) {
                                    // data is ur summary
                                    $('#contactview').html(data);
                                }

                            });

                        }
                    </script>
                    <div id="contactlist" class="col-xs modal fade aside aside-sm  b-r" id="list">
                        <div class="row-col">
                            <div class="row-row">
                                <div class="row-col">
                                    <div id="contactlist" class="col-xs">
                                        <div class="row-col white bg">
                                            <!-- flex content -->
                                            <div class="row-row">
                                                <div class="row-body scrollable hover">
                                                    <div class="row-inner">
                                                        <!-- left content -->
                                                        <div class="list" data-ui-list="b-r b-3x b-primary">

                                                            <?php
                                                            $j = 0;
                                                            $i = 0;
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id = $row["id"];
                                                                    $i = $i + 1;
                                                            ?>
                                                                    <div class="list-item ">
                                                                        <div class="list-left">
                                                                            <?php
                                                                            $butnclr[0] = "cyan";
                                                                            $butnclr[1] = "green";
                                                                            $butnclr[2] = "pink";
                                                                            $butnclr[3] = "blue-grey";
                                                                            $butnclr[4] = "teal";
                                                                            $butnclr[5] = "blue";
                                                                            $butnclr[6] = "grey";
                                                                            $butnclr[7] = "light-blue";
                                                                            $butnclr[8] = "indigo";
                                                                            $butnclr[9] = "brown";
                                                                            $j = $id % 10;
                                                                            ?>
                                                                            <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"]; ?>)">
                                                                                <span class="w-40 avatar circle <?php echo $butnclr[$j]; ?>">
                                                                                    <?php
                                                                                    $words = explode(" ", $row["name"]);
                                                                                    $acronym = "";
                                                                                    foreach ($words as $w) {
                                                                                        if (!empty($w)) {
                                                                                            $acronym .= $w[0];
                                                                                        }
                                                                                    }
                                                                                    $acronym = strtoupper(substr($acronym, 0, 3));
                                                                                    echo $acronym;
                                                                                    ?>
                                                                                </span></a>
                                                                        </div>
                                                                        <div class="list-body">
                                                                            <div class="item-title">

                                                                                <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"]; ?>)" class="_500">
                                                                                    <td><?php echo ucwords($row["name"]); ?></td>
                                                                                </a>
                                                                            </div>
                                                                            <small class="block text-muted text-ellipsis">
                                                                                <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"]; ?>)">
                                                                                    <?php echo $row["email"]; ?></a>
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- footer -->
                            <div class="white bg p-a b-t clearfix">
                                <div class="btn-group pull-right">
                                    <a class="btn btn-xs white circle">#CybozCRM</a>
                                </div>
                                <span class="text-sm text-muted">Recent: <strong><?php echo $i; ?></strong></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM customers where id=$id";
                    } else if (isset($_GET['type'])) {
                        $sql = "SELECT * FROM customers where type='$type' ORDER BY name ASC LIMIT 1";
                    } else {
                        $sql = "SELECT * FROM customers ORDER BY id DESC LIMIT 1";
                    }

                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            $name = $row["name"];
                            $gst = $row["gst"];
                            $person = $row["person"];
                            $address = $row["address"];
                            $email = $row["email"];
                            $fax = $row["fax"];
                            $phone = $row["phone"];
                            $mobile = $row["mobile"];
                            $type = $row["type"];
                        }
                    }

                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <div id="contactview" class="col-xs">
                            <div class="row-col white bg">
                                <!-- flex content -->
                                <div class="row-row">
                                    <div class="row-body scrollable hover">
                                        <div class="row-inner">
                                            <!-- content -->
                                            <div class="p-a-lg text-center">
                                                <?php
                                                $butnclr[0] = "cyan";
                                                $butnclr[1] = "green";
                                                $butnclr[2] = "pink";
                                                $butnclr[3] = "blue-grey";
                                                $butnclr[4] = "teal";
                                                $butnclr[5] = "blue";
                                                $butnclr[6] = "grey";
                                                $butnclr[7] = "light-blue";
                                                $butnclr[8] = "indigo";
                                                $butnclr[9] = "brown";
                                                $j = 0;
                                                $j = $id % 10;
                                                ?>
                                                <a href="#">
                                                    <span class="w-40 avatar circle animated rollIn <?php echo $butnclr[$j]; ?>">
                                                        <?php
                                                        $words = explode(" ", $name);
                                                        $acronym = "";
                                                        foreach ($words as $w) {
                                                            $acronym .= $w[0];
                                                        }
                                                        $acronym = strtoupper(substr($acronym, 0, 3));
                                                        echo $acronym;
                                                        ?>
                                                    </span></a>
                                                <div class="animated fadeInUp">
                                                    <div>
                                                        <span class="text-md m-t block"><?php echo ucwords($name); ?></span>
                                                        <br />
                                                        <a href="javascript:void(0);" onclick="contact_type('<?php echo $type; ?>')" class="btn btn-outline btn-sm rounded b-info text-info"><?php echo $type; ?></a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="p-a-md animated fadeInUp">
                                                <ul class="nav">
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Contact Person/Designation <i class="fa fa-fw fa-user"></i></b>
                                                            </span>
                                                            <span><?php echo ucwords($person) . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Address <i class="fa fa-fw fa-map-marker"></i></b>
                                                            </span>
                                                            <span><?php echo $address . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>GST <i class="fa fa-fw fa-bank"></i></b>
                                                            </span>
                                                            <span><?php echo $gst . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Phone <i class="fa fa-fw fa-tty"></i></b>
                                                            </span>
                                                            <span><?php echo $phone . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Fax <i class="fa fa-fw fa-fax"></i></b>
                                                            </span>
                                                            <span><?php echo $fax . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Mobile <i class="fa fa-fw fa-phone-square"></i></b>
                                                            </span>
                                                            <span><?php echo $mobile . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-b-xs">
                                                        <a class="nav-link text-muted block">
                                                            <span class="pull-right text-sm">
                                                                <b>Email <i class="fa fa-fw fa-envelope"></i></b>
                                                            </span>
                                                            <span><?php echo $email . "&nbsp;"; ?></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- / -->
                                        </div>
                                    </div>
                                </div>
                                <!-- / -->

                                <!-- footer -->
                                <div class="p-a b-t clearfix">
                                    <div class="pull-right">
                                        <?php
                                        // session_start();
                                        if ($_SESSION['role'] == 'admin') { ?>
                                            <a href="<?php echo BASEURL;?>/controller?controller=contacts&submit_delete_customer=delete&id=<?php echo $id;?>"
                                            onclick="return confirm('Are you sure?')" class="btn btn-xs white rounded">
                                                <i class="fa fa-trash m-r-xs"></i>
                                                Delete
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <a href="<?php echo BASEURL; ?>/edit/customer?id=<?php echo $id; ?>" class="btn btn-xs primary rounded">
                                        <i class="fa fa-pencil m-r-xs"></i>
                                        Edit
                                    </a>
                                </div>
                                <!-- / -->
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-xs">
                            <div class="row-col white bg">
                                <!-- flex content -->
                                <div class="row-row">
                                    <div class="row-body scrollable hover">
                                        <div class="row-inner">
                                            <!-- content -->
                                            <div class="p-a-lg text-center">
                                                <a href="#">
                                                    <span class="w-40 avatar circle animated rollIn danger">
                                                        <h3>!</h3>
                                                    </span></a>
                                                <div class="animated fadeInUp">
                                                    <div>
                                                        <span class="text-md m-t block">Empty Stack</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- / -->
                                        </div>
                                    </div>
                                </div>
                                <!-- / -->

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ############ PAGE END-->

</div>
</div>
<!-- / -->

<?php include "includes/footer.php"; ?>