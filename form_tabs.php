<?php
/**
 * علامات التبويب والنماذج
 * 
 * يحتوي على علامات التبويب والنماذج لإنشاء مشاريع مختلفة.
 * 
 * @package ProjectManagement
 */
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tableTab">
            <i class="fas fa-table tab-icon"></i>
            Table
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#formTab">
            <img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" alt="WordPress" class="tab-icon">
            WordPress
        </a>
    </li>
    <!-- أضف باقي علامات التبويب هنا -->
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <!-- Table Tab -->
    <div class="tab-pane container active" id="tableTab">
        <?php include 'table_content.php'; ?>
    </div>

    <!-- Form Tab (WordPress) -->
    <div class="tab-pane container fade" id="formTab">
        <form id="myForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="site-name" class="form-label">Site</label>
                        <input type="text" class="form-control" id="site-name" name="site_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="database" class="form-label">Database</label>
                        <input type="text" class="form-control" id="database" name="database">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="explain_" class="form-label">Explain</label>
                        <textarea class="form-control" id="explain_" name="explain_"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="submitBtn">Register a new WordPress website</button>
                </div>
            </div>
        </form>
        
        <!-- Loading spinner -->
        <div id="loadingSpinner" class="d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="text-primary mt-2">جارٍ التحميل...</div>
        </div>
        
        <!-- Display response -->
        <div id="div"></div>
    </div>

    <!-- أضف باقي محتوى علامات التبويب هنا -->
</div>