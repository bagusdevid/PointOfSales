<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $page_title.' | '.$Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <?php if ($this->db->dbdriver != 'sqlite3') { ?>
    <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?=site_url('login')?>'; }</script>
    <?php } ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body class="login-page login-page-<?= $Settings->theme_style; ?> rtl rtl-inv">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?=base_url();?>"><?= $Settings->site_name == 'POS' ? 'Point of<b>Sales</b>' : '<img src="'.base_url('uploads/'.$Settings->logo).'" alt="'.$Settings->site_name.'" />'; ?></a>
        </div>
        <div class="login-box-body">
            <?php if ($error)  { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $error; ?>
            </div>
            <?php } if ($message) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $message; ?>
            </div>
            <?php } ?>
            <p class="login-box-msg"><?= lang('login_to_your_account'); ?></p>
            <?= form_open("auth/login"); ?>
            <div class="form-group has-feedback">
                <input type="text" name="identity" value="" class="form-control" placeholder="<?= lang('username'); ?>" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" value="" class="form-control" placeholder="<?= lang('password'); ?>" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="glyphicon glyphicon-log-in"></i> &nbsp;<?= lang('sign_in'); ?></button>
            <?= form_close(); ?>
    </div>
  </div>

    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?= $assets ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $assets ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

</body>
</html>
