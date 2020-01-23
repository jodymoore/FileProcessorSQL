<?php
require_once('header.html');
?>


<body>

<div id="card" class="card">
    <div class="card-header">
        <h2>CSV PROCESSOR</h2>
    </div>
        <div class="card-body">
            <h4 class="mt-5">Please upload .csv file</h4>
            <form class="form-horizontal" action="processFile.php" method="post" name="uploadCSV"
                  enctype="multipart/form-data">
                <div id="cardRow" class="justify-content-around">
                    <label class="col-md-6 control-label">Choose CSV File</label>
                    <input type="file" name="file" id="file" accept=".csv" required>
                    <br/>

                </div>
                <div id="buttonDiv" >
                    <button type="submit" id="submit" name="submit"
                            class="btn-submit">PROCESS FILE</button>
                </div>
                <div id="labelError"></div>
            </form>
        </div>
</div>

</body>
</html>

