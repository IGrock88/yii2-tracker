<script>
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        console.log(e.data);
    };
</script>

<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 29.08.2018
 * Time: 12:41
 */