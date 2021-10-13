 <!--LOCAL JS-->
 <script src=""></script>
        <!--JQUERY-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <!-- MATERIALIZE JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <!--JAVASCRIPT-->
        <script type="text/javascript">
        //INICIALIZAÇÃO
        $(document).ready(function(){
        });
    </script>
        <!--MODAL-INIT-->
    <script>
     document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
  });

      //SIDENAV INIT
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems,);
  });
        // SCROLLSPY
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.scrollspy');
            var instances = M.ScrollSpy.init(elems, {
                throttle:100,
                scrollOffset: 100,
            });
  });

        //TOLLTIPS
  $(document).ready(function(){
    $('.tooltipped').tooltip();
  });
      </script>
 
      <script>
      //JAVASCRIPT INIT
       document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems);
  });
      </script>
</body>
</html>