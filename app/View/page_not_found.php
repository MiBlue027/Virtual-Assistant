<div class="excpt_pg_not_found-wrapper">
    <div class="excpt_pg_not_found-box">
        <h1 class="excpt_pg_not_found-code">404</h1>
        <p class="excpt_pg_not_found-text"> Oops! Your page is not found. </p>


        <button class="excpt_pg_not_found-btn" id="excpt_pg_not_found-back"> Back </button>
    </div>
</div>


<script>
    document.getElementById('excpt_pg_not_found-back').addEventListener('click', function(){
        if(history.length > 1) history.back(); else window.location.href = '/';
    });
</script>