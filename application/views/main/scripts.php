<script src="<?=base_url('js/jquery.min.js?v=2'); ?>" type="text/javascript"></script>
<script src="<?=base_url('js/jquery.tablesorter.js?v=2');?>" type="text/javascript"></script> 
<script src="<?=base_url('js/bootstrap.min.js?v=2'); ?>" type="text/javascript"></script>
<script src="<?=base_url('js/jquery-ui.js?v=2'); ?>" type="text/javascript"></script>
<script src="<?=base_url('js/metisMenu.js?v=2');?>" type="text/javascript"></script>
<script src="<?=base_url('js/sb-admin-2.js?v=2');?>" type="text/javascript"></script>
<script src="<?=base_url('js/main.js?v=2');?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
         $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
          });
    });
</script>