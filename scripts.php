<?php
/**
 * البرامج النصية JavaScript
 * 
 * يحتوي على جميع البرامج النصية JavaScript المستخدمة في التطبيق.
 * 
 * @package ProjectManagement
 */
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-form@4.3.0/dist/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // دالة لتشغيل شريط التقدم
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
                setTimeout(() => runProgressStep(step + 1), stepTime);
            }
        }

        runProgressStep(0);
    }
</script>