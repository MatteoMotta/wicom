<?
# fisso colori CSS
$body_class = "body-light-linen";
$page_header_class = "page-header-green";
$side_menu_class = "side-menu-green";
$content_inner_class = "content-inner-white";

# per ricerca js
if (isset($_REQUEST['search']))
  $search = mysqli_real_escape_string($link,$_REQUEST['search']);
else
  $search = "";

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- <link rel='stylesheet' href='assets/css/fullcalendar.css'> -->
  <!-- <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.css'> -->
  <!-- <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.print.css'> -->
  <link rel='stylesheet' href='assets/css/datatables/datatables.css'>
  <link rel='stylesheet' href='assets/css/datatables/bootstrap.datatables.css'>
  <link rel='stylesheet' href='assets/scss/chosen.css'>
  <link rel='stylesheet' href='assets/scss/font-awesome/font-awesome.css'>
  <link rel='stylesheet' href='assets/css/app.css'>
  <link rel='stylesheet' href='assets/css/tagmanager/tagmanager.css'>
  <link rel='stylesheet' href='assets/css/datepicker.css'>
  <link rel='stylesheet' href='assets/css/bootstrap-lightbox.min.css'>
  <link rel='stylesheet' href='assets/css/ekko-lightbox.min.css'>

  <link rel='stylesheet' href='chosen.min.css'>
  <link rel='stylesheet' href='style.css'>

  <link href='//fonts.googleapis.com/css?family=Oswald:300,400,700|Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

  <link href="assets/favicon.png" rel="shortcut icon">
  <link href="assets/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->

  <!-- typeahead hook -->
  <link href="assets/css/typeahead.js-bootstrap.css" rel="stylesheet" media="screen">

  <title><?=isset($title)?"$title - ".SITE_NAME:SITE_NAME?> </title>

</head>

<body class="<?=$body_class?>">
