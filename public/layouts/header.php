<html>

<head>
  <title>Photo Gallery</title>
  <link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <style>
    #main {
      height: fit-content;
      background-color: #faffcb;
      width: auto;
      padding: 2em;
    }

    .content {
      text-align: center;
      box-sizing: border-box;
    }

    .btn {
      background-color: #eee4b9be;
      border: 3px solid black;
      border-radius: 10px;
      padding: 10px;
      font-size: 15px;
    }

    .btn:hover {
      background-color: red;
      border: 3px solid black;
      border-radius: 10px;
      padding: 10px;
    }

    .column {
      float: left;
      width: 26%;
      padding: 42px;
      padding-bottom: 100px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    ::-webkit-scrollbar {
      width: 1px;
    }

    ::-webkit-scrollbar-thumb {
      border: 7px solid transparent;
      background-color: #000000c2;
      background-clip: content-box;
    }


    input[type=text],
    select,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    label {
      padding: 12px 12px 12px 0;
      display: inline-block;
    }

    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .container {
      border-radius: 5px;
      padding: 20px;
    }

    .col-25 {
      float: left;
      width: 10%;
      margin-top: 6px;
      margin-left: 6%;
    }

    .col-75 {
      float: left;
      width: 75%;
      margin-top: 6px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    @media screen and (max-width: 600px) {

      .col-25,
      .col-75,
      input[type=submit] {
        margin-top: 0;
      }
    }


    footer {
      padding-top: 10px;
      font-size: 20px;
      text-align: center;
      background: #000000c2;
      color: #ffffff;
      height: 3%;
    }
  </style>
</head>

<body>
  <div id="header">
    <h1>Photo Gallery <a href="admin/login.php" style="float: right; color: white; text-decoration: none;"><i class="fa fa-user" style="font-size:24px;"></i> Login </a></h1>
  </div>
  
  <div id="main">