    </div>
    <footer>
      <div id="footer">&copy; <?php echo date("F j, Y", time()); ?>, Ashish Panchal</div>
    </footer>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>