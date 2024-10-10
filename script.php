<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-form@4.3.0/dist/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to run the progress bar
    function runProgressBar(totalTime) {
        const progressBar = document.getElementById('progress-bar');
        const progressBarContainer = document.getElementById('progress-bar-container');
        const progressBarLength = progressBarContainer.clientWidth;
        const stepTime = totalTime / progressBarLength;

        function updateProgressBar(progress) {
            progressBar.style.width = `${progress}px`;
        }

        function runProgressStep(step) {
            updateProgressBar(step);
            if (step < progressBarLength) {
                setTimeout(() => runProgressStep(step + 1), stepTime * 1000);
            } else {
                console.log("Done!");
            }
        }

        runProgressStep(0);
    }

    $(document).ready(function () {
        $("#submitBtn").click(function () {
            var formData = $("#myForm").serialize();
            const totalTimeInSeconds = 150;

            // Display the progress bar
            runProgressBar(totalTimeInSeconds);
            // Show the loading spinner
            $("#loadingSpinner").removeClass("d-none");

            $.ajax({
                type: "POST",
                url: "process.php",
                data: formData,
                dataType: 'html',
                success: function (response) {
                    // Hide the loading spinner on success
                    $("#loadingSpinner").addClass("d-none");

                    // Display the response in the 'div' element
                    $('#div').html(response);
                    console.log(response);
                },
                error: function (error) {
                    // Hide the loading spinner on error
                    $("#loadingSpinner").addClass("d-none");

                    console.log(error);
                }
            });
        });

        $("#submitBtn1").click(function () {
            var formData = $("#Laravel").serialize();
            // Show the loading spinner
            const totalTimeInSeconds = 50;

            // Display the progress bar
            runProgressBar(totalTimeInSeconds);
            $("#loadingSpinner1").removeClass("d-none");
            $.ajax({
                type: "POST",
                url: "Laravel.php",
                data: formData,
                dataType: 'html',
                success: function (response) {
                    // Hide the loading spinner on success
                    $("#loadingSpinner1").addClass("d-none");
                    // Display the response in the 'div' element
                    $('#div11').html(response);
                    console.log(response);
                },
                error: function (error) {
                    // Hide the loading spinner on error
                    $("#loadingSpinner").addClass("d-none");

                    console.log(error);
                }
            });
        });

        $("#submitBtn2").click(function () {
            var formData = $("#Flutter").serialize();
            // Show the loading spinner
            $("#loadingSpinner").removeClass("d-none");
            $.ajax({
                type: "POST",
                url: "Flutter.php",
                data: formData,
                dataType: 'html',
                success: function (response) {
                    // Hide the loading spinner on success
                    $("#loadingSpinner").addClass("d-none");
                    // Display the response in the 'div' element
                    $('#div2').html(response);
                    console.log(response);
                },
                error: function (error) {
                    // Hide the loading spinner on error
                    $("#loadingSpinner").addClass("d-none");

                    console.log(error);
                }
            });
        });

        $("#submitBtn33").click(function () {
            const totalTimeInSeconds = 30;

            // Display the progress bar
            runProgressBar(totalTimeInSeconds);
            var formData = $("#Google").serialize();
            // Show the loading spinner
            $("#loadingSpinner33").removeClass("d-none");
            $.ajax({
                type: "POST",
                url: "Google.php",
                data: formData,
                dataType: 'html',
                success: function (response) {
                    // Hide the loading spinner on success
                    $("#loadingSpinner33").addClass("d-none");
                    // Display the response in the 'div' element
                    $('#div33').html(response);
                    console.log(response);
                },
                error: function (error) {
                    // Hide the loading spinner on error
                    $("#loadingSpinner33").addClass("d-none");

                    console.log(error);
                }
            });
        });
    });
</script>