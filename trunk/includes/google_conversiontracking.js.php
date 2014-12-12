<?php
/* -----------------------------------------------------------------------------------------
   $Id: google_conversiontracking.js.php 1116 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (google_conversiontracking.js.php,v 1.3 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>

<?php if (GOOGLE_CONVERSION == 'true') { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo GOOGLE_CONVERSION_ID; ?>', 'auto');
  ga('send', 'pageview');

</script>
<?php } ?>
<?php if (YANDEX_METRIKA == 'true') { ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {};
</script>

<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter<?php echo YANDEX_METRIKA_ID; ?> = new Ya.Metrika({id:<?php echo YANDEX_METRIKA_ID; ?>, enableAll: true,webvisor:true,ut:"noindex",params:window.yaParams||{ }});
        }
        catch(e) { }
    });
})(window, 'yandex_metrika_callbacks');
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/<?php echo YANDEX_METRIKA_ID; ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php } ?>