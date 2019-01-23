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
  ga('require', 'displayfeatures');  
  ga('send', 'pageview');

</script>
<?php } ?>
<?php if (YANDEX_METRIKA == 'true') { ?>
<!-- Yandex.Metrika counter -->
<script>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(<?php echo YANDEX_METRIKA_ID; ?>, "init", {
        id:<?php echo YANDEX_METRIKA_ID; ?>,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>

<noscript><div><img src="https://mc.yandex.ru/watch/<?php echo YANDEX_METRIKA_ID; ?>?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php } ?>