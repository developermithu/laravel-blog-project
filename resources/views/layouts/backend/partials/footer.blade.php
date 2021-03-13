<footer class="main-footer bg-dark">
    Copyright &copy; 2019- <?php echo date('Y'); ?> <strong> <a href="#">Developermithu</a>.</strong>
    All rights reserved
    <div class="float-right d-none d-sm-inline-block">
      Developed By <strong><a href="http://mithu.epizy.com" target="blank">Mithu</a></strong>
    </div>
  </footer>
  
  </div>
  <!-- ./wrapper -->
  
  
  <!-- jQuery -->
  <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('backend/plugins/fastclick/fastclick.js')}}"></script>
  <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
  <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>
  <script src="{{asset('backend/plugins/adminlte.min.js')}}"></script>
  
  <script>
    $(function() {
      // Tooltip
      $('[data-toggle="tooltip"]').tooltip();
  
      // Ckeditor
      ClassicEditor
          .create( document.querySelector( '#editor' ) )
          .catch( error => {
              console.error( error );
          } );
    });
  </script>

  {{-- Datatables --}}
  @stack('footer') 

  </body>

  </html>