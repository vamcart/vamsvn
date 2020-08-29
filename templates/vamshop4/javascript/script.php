<script>
  //if (window.location.protocol === 'http:') {
    //window.location.protocol = 'https:';
  //}
  // If `prefers-color-scheme` is not supported, fall back to light mode.
  // In this case, light.css will be downloaded with `highest` priority.
  if (!window.matchMedia('(prefers-color-scheme)').matches) {
    document.documentElement.style.display = 'none';
    document.head.insertAdjacentHTML(
        'beforeend',
        '<link rel="stylesheet" href="templates/<?php echo CURRENT_TEMPLATE; ?>/css/light.css" onload="document.documentElement.style.display = ``">'
    );
  }
</script>  
<script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
<?php
if (file_exists(dirname(__FILE__) . '/local.js.php')) include('local.js.php');
?>