<html>

<div class="ml-4 text-center text-xs text-gray-500 sm:text-center sm:ml-0">
    <a href="" target="_blank" class="text-gray-900 dark:text-white">© 2022 - <span id="currentYear"></span> - {{ env('APP_NAME') }}</a>
    All Rights Reserved 
    <br>Profesional Dashboards By
    <a href="{{ env('APP_MAKER_LINK') }}" target="_blank" class="text-gray-900 dark:text-white">{{ env('APP_MAKER') }}</a>
</div>

<script>
    // JavaScript to get the current year
    document.getElementById('currentYear').innerHTML = new Date().getFullYear();
</script>


</html>