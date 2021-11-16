<html>

<head>
  <title>Photo Gallery : Admin</title>
  <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
  <style>
    #main {
      height: auto;
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
      width: 25%;
      padding: 35px;
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

    .img {
      width: 300;
    }

    .image {
      width: 300px;
      height: 200px;
    }

    @media only screen and (max-width: 1067px) {
      .img {
        width: 100%;
      }

      .image {
        width: 300;
        height: 200;
      }

      .column {
        float: left;
        width: 40%;
      }

      .row:after {
        content: "";
        display: table;
      }
    }
  </style>
</head>

<body>
  <div id="header">
    <h1>Photo Gallery : Admin</h1>
  </div>
  <div id="main">