<?php include "allproducts.php"; ?>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('q');
    document.querySelector('.directory #category-name').innerHTML = ` Wyszukiwanie: ${searchTerm}`;
    document.querySelector('.box-directory h1').innerHTML = ` Wyszukiwanie: ${searchTerm}`;
</script>
</script>