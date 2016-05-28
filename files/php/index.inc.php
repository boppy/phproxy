<?php
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])){
    exit(0);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>PHProxy</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./files/css/style.css" title="Default Theme" media="all" />
    <script>
    function onLoadAction(){
        var authInput = document.getElementById('username');
        var addrInput = document.getElementById('address_box');

        (authInput||addrInput).focus();
    }
    </script>
</head>

<body onload="onLoadAction()">
<div id="container">
  <h1 id="title">PHProxy</h1><ul id="navigation">
    <li><a href="<?php echo $GLOBALS['_script_base'] ?>">URL Form</a></li>
    <!-- li><a href="javascript:alert('cookie managment has not been implemented yet')">Manage Cookies</a></li -->
  </ul>
<?php

switch ($data['category']) {
    case 'auth':
?>
    <div id="auth">
        <p>Enter your username and password for &quot;<strong><?php echo htmlspecialchars($data['realm']) ?></strong>&quot; on <strong><?php echo $GLOBALS['_url_parts']['host'] ?></strong></p>
        <form method="post" action="">
            <input type="hidden" name="<?php echo $GLOBALS['_config']['basic_auth_var_name'] ?>" value="<?php echo base64_encode($data['realm']) ?>">
            <ul>
                <li class="input"><label for="username">Username</label><input placeholder="Username" type="text" name="username" id="username"
                ><li><li class="input"><label for="password">Password</label><input placeholder="Password" type="password" name="password" id="password"
                ></li><li class="button"><input type="submit" value="Login"></li>
            </ul>
        </form>
    </div>
<?php
        break;
    case 'error':
        echo '<div id="error"><p>';

        switch($data['group']){
            case 'url':
                echo '<b>URL Error (' . $data['error'] . ')</b>: ';
                switch($data['type']){
                    case 'internal':
                        $message = 'Failed to connect to the specified host. '
                                 . 'Possible problems are that the server was not found, the connection timed out, or the connection refused by the host. '
                                 . 'Try connecting again and check if the address is correct.';
                        break;
                    case 'external':
                        switch($data['error']) {
                            case 1:
                                $message = 'The URL you are attempting to access is blacklisted by this server. Please select another URL.';
                                break;
                            case 2:
                                $message = 'The URL you entered is malformed. Please check whether you entered the correct URL or not.';
                                break;
                        }
                        break;
                }
                break;
            case 'resource':
                echo '<b>Resource Error:</b> ';
                switch($data['type']){
                    case 'file_size':
                        $message = 'The file your are attempting to download is too large.<br />'
                                 . 'Maxiumum permissible file size is <b>' . number_format($GLOBALS['_config']['max_file_size']/1048576, 2) . ' MB</b><br />'
                                 . 'Requested file size is <b>' . number_format($GLOBALS['_content_length']/1048576, 2) . ' MB</b>';
                        break;
                    case 'hotlinking':
                        $message = 'It appears that you are trying to access a resource through this proxy from a remote Website.<br />'
                                 . 'For security reasons, please use the form below to do so.';
                        break;
                }
                break;
        }

        echo 'An error has occured while trying to browse through the proxy. <br />' . $message . '</p></div>';
        break;
}
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <ul id="form">
            <li id="address_bar"><label>Web Address</label><input id="address_box" type="text" name="<?php echo $GLOBALS['_config']['url_var_name'] ?>" value="<?php echo isset($GLOBALS['_url']) ? htmlspecialchars($GLOBALS['_url']) : '' ?>" onfocus="this.select()" /><input id="go" type="submit" value="Go" /></li>
<?php
foreach($GLOBALS['_flags'] as $flag_name => $flag_value){
    if (!$GLOBALS['_frozen_flags'][$flag_name]){
        echo '<li class="option"><input type="checkbox" name="' . $GLOBALS['_config']['flags_var_name'] . '[' . $flag_name . ']"' . ($flag_value ? ' checked="checked"' : '') . ' id="f-' . $flag_name . '" /><label for="f-' . $flag_name . '">' . $GLOBALS['_labels'][$flag_name][1] . '</label></li>' . "\n";
    }
}
?>
        </ul>
    </form>

    <div id="footer"><a href="https://phproxy.github.io">PHProxy</a></div>
</div>
</body>
</html>
