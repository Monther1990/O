<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check for login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<body>
    <header class="header">
        <div class="nav-container">
            <a href="dashboard.php" class="nav-brand">نظام التقييم </a>
            <nav class="nav-menu">
                <a href="dashboard.php" class="nav-link">الرئيسية</a>
                <a href="evaluations.php" class="nav-link active">التقييمات</a>
                <a href="employees.php" class="nav-link">الموظفين</a>
                <a href="reports.php" class="nav-link">التقارير</a>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <a href="user.php" class="nav-link">إدارة المستخدمين</a>
                <?php endif; ?>
                <a href="logout.php" class="nav-link">تسجيل الخروج</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <section class="sub-header">
            <h1> إضافة التقييمات</h1>
            <a href="new_evaluation.php" class="btn btn-primary">تقييم جديد</a>
        </section>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نموذج تقييم جديد - نظام التقييم </title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
</head>
<body>


<section class="form-section">
    <h2>درجات الأداء</h2>
    <div class="performance-grid">
        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('job_knowledge')">
            <label>المعرفة الوظيفية</label>
            <div class="rating-group">
                <input type="range" id="job_knowledge" name="scores[job_knowledge]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('work_quality')">
            <label>جودة العمل</label>
            <div class="rating-group">
                <input type="range" id="work_quality" name="scores[work_quality]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('productivity')">
            <label>الإنتاجية</label>
            <div class="rating-group">
                <input type="range" id="productivity" name="scores[productivity]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('communication')">
            <label>التواصل</label>
            <div class="rating-group">
                <input type="range" id="communication" name="scores[communication]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('teamwork')">
            <label>العمل الجماعي</label>
            <div class="rating-group">
                <input type="range" id="teamwork" name="scores[teamwork]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('initiative')">
            <label>المبادرة</label>
            <div class="rating-group">
                <input type="range" id="initiative" name="scores[initiative]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>

        <div class="score-card" style="cursor: pointer;" onclick="openMetricModal('dependability')">
            <label>الاعتمادية</label>
            <div class="rating-group">
                <input type="range" id="dependability" name="scores[dependability]" 
                       min="0" max="5" step="0.1" value="0" class="form-control" readonly>
                <span class="score-value">0.0</span>
            </div>
        </div>
    </div>


            <div class="button-group">
                <button type="submit" class="btn btn-primary">حفظ التقييم</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">إلغاء</button>
            </div>
        </form>
    </div>
    <style>
   :root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --secondary-color: #6b7280;
    --success-color: #059669;
    --warning-color: #d97706;
    --danger-color: #dc2626;
    --background-color: #f3f4f6;
    --surface-color: #ffffff;
    --text-primary: #1f2937;
    --text-secondary: #4b5563;
    --border-color: #e5e7eb;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Cairo', sans-serif;
}
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: var(--surface-color);
    margin: 5% auto;
    padding: 2rem;
    border-radius: 0.75rem;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.close {
    color: #6b7280;
    float: left;
    font-size: 1.75rem;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s;
}

.close:hover {
    color: #1f2937;
}

.criteria-container {
    margin: 1.5rem 0;
}

.criteria-item {
    margin: 1rem 0;
    padding: 1rem;
    background: var(--background-color);
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
}

.criteria-item label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--text-primary);
}

.criteria-range {
    width: calc(100% - 50px);
    margin-right: 0;
    height: 6px;
    background: var(--border-color);
    border-radius: 3px;
    outline: none;
}

.criteria-value {
    display: inline-block;
    width: 40px;
    text-align: center;
    font-weight: bold;
    color: var(--primary-color);
}

.score-card {
    transition: transform 0.2s ease;
}

.score-card:hover {
    transform: translateY(-2px);
}

.score-card input[type="range"] {
    pointer-events: none !important;
    opacity: 0.7;
}

.score-card {
    cursor: pointer;
}
body {
    background-color: var(--background-color);
    color: var(--text-primary);
    line-height: 1.6;
}

/* Navigation Header Styles */
.header {
    background-color: var(--primary-color);
    color: white;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.nav-brand {
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    text-decoration: none;
}

.nav-menu {
    display: flex;
    gap: 1.5rem;
}


.nav-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
    position: relative;
    padding-bottom: 0.25rem;
}

.nav-link:hover {
    color: white;
}

.nav-link.active {
    color: white;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: white;
}

.container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.sub-header {
    background: var(--surface-color);
    padding: 1.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sub-header h1 {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--text-primary);
}

.filters {
    background: var(--surface-color);
    padding: 1.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-family: 'Cairo', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.table-container {
    background: var(--surface-color);
    border-radius: 0.75rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 1rem;
    text-align: right;
    border-bottom: 1px solid var(--border-color);
}

th {
    background-color: #f8fafc;
    font-weight: 700;
    color: var(--text-primary);
    white-space: nowrap;
}

tr:hover {
    background-color: #f8fafc;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-family: 'Cairo', sans-serif;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
}

.status-completed {
    background-color: #d1fae5;
    color: var(--success-color);
}

.status-pending {
    background-color: #fef9c7;
    color: var(--warning-color);
}

.rating {
    font-weight: 700;
}

.rating-high {
    color: var(--success-color);
}

.rating-medium {
    color: var(--warning-color);
}

.rating-low {
    color: var(--danger-color);
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.page-btn {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    background: var(--surface-color);
    cursor: pointer;
    font-weight: 600;
    font-family: 'Cairo', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
    color: var(--text-primary);
}

.page-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.page-btn.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.no-data {
    text-align: center;
    padding: 2rem;
    color: var(--text-secondary);
    font-weight: 600;
}

.search-wrapper {
    position: relative;
}

.search-wrapper .loading-indicator {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    display: none;
    color: var(--text-secondary);
}

.search-wrapper.loading .loading-indicator {
    display: block;
}

.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1000;
    background-color: white;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    font-family: 'Cairo', sans-serif !important;
    padding: 0.5rem;
}

.ui-menu-item {
    padding: 0.5rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-family: 'Cairo', sans-serif !important;
}

.ui-menu .ui-menu-item-wrapper {
    padding: 0.5rem;
    font-family: 'Cairo', sans-serif !important;
}

.ui-menu .ui-menu-item-wrapper.ui-state-active {
    background-color: var(--primary-color);
    color: white;
    border: none;
    margin: 0;
}

@media (max-width: 768px) {
    .header {
        padding: 1rem;
    }

    .nav-menu {
        display: none; /* Consider implementing a mobile menu */
    }

    .sub-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .table-container {
        overflow-x: auto;
    }

    th, td {
        min-width: 120px;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

    .form-section {
        background: var(--surface-color);
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .form-section h2 {
        color: var(--text-primary);
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .performance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .score-card {
        background: var(--surface-color);
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
    }

    .rating-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .score-value {
        min-width: 3rem;
        text-align: center;
        font-weight: bold;
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    input[type="range"] {
        width: 100%;
        height: 6px;
        background: var(--border-color);
        border-radius: 3px;
        outline: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        font-size: 1rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    .btn-secondary {
        background-color: var(--text-secondary);
        color: white;
    }

    .btn-secondary:hover {
        background-color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .form-grid, .performance-grid {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeIdInput = document.getElementById('employee_id');
    
    employeeIdInput.addEventListener('input', function() {
        const inputValue = this.value;
        const numericValue = inputValue.replace(/[^0-9]/g, '');
        
        if (numericValue.length > 0 && !inputValue.startsWith('D1-')) {
            this.value = 'D1-' + numericValue;
        } else if (numericValue.length === 0) {
            this.value = '';
        }
    });

    employeeIdInput.addEventListener('keypress', function(event) {
        const keyCode = event.which || event.keyCode;
        const keyValue = String.fromCharCode(keyCode);
        const isEnglishNumber = /^[0-9]+$/.test(keyValue);

        if (!isEnglishNumber) {
            event.preventDefault();
        }
    });
});
    
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('evaluationForm');
    const rangeInputs = document.querySelectorAll('input[type="range"]');
    const userRole = '<?php echo $_SESSION["user_role"]; ?>';
    const userDepartment = '<?php echo $_SESSION["user_department"]; ?>';

    // Modal Configuration
    const CRITERIA_CONFIG = {
    job_knowledge: {
        title: "معايير المعرفة الوظيفية",
        criteria: [
            {
                name: "فهم الإجراءات وأنظمة العمل",
                descriptions: {
                    low: { range: "0 - 1.5", text: "يحتاج إلى إشراف مستمر لفهم الإجراءات والأنظمة الأساسية" },
                    medium: { range: "1.6 - 2.5", text: "يظهر فهماً أساسياً للإجراءات والأنظمة مع الحاجة للتوجيه أحياناً" },
                    high: { range: "2.6 - 4.0", text: "لديه إلمام جيد في الإجراءات والأنظمة ويطبقها باستقلالية" },
                    excellent: { range: "4.1 - 5.0", text: "متميز في فهم وتحليل وتطوير الإجراءات والأنظمة" }
                }
            },
            {
                name: "المعرفة بالقوانين واللوائح العسكرية",
                descriptions: {
                    low: { range: "0 - 1.5", text: "معرفة محدودة بالقوانين واللوائح الأساسية" },
                    medium: { range: "1.6 - 2.5", text: "معرفة مقبولة بالقوانين واللوائح مع بعض الثغرات" },
                    high: { range: "2.6 - 4.0", text: "معرفة شاملة بالقوانين واللوائح وتطبيقاتها" },
                    excellent: { range: "4.1 - 5.0", text: "خبير في القوانين واللوائح ومرجع للآخرين" }
                }
            },
            {
                name: "القدرة على تطبيق المعرفة في العمل",
                descriptions: {
                    low: { range: "0 - 1.5", text: "صعوبة في تطبيق المعرفة النظرية عملياً" },
                    medium: { range: "1.6 - 2.5", text: "يطبق المعرفة الأساسية بشكل مقبول" },
                    high: { range: "2.6 - 4.0", text: "يطبق المعرفة بكفاءة في مختلف المواقف" },
                    excellent: { range: "4.1 - 5.0", text: "يبتكر طرقاً جديدة لتطبيق المعرفة وتحسين العمل" }
                }
            },
            {
                name: "الإلمام بالمهام والمسؤوليات",
                descriptions: {
                    low: { range: "0 - 1.5", text: "فهم محدود للمهام والمسؤوليات" },
                    medium: { range: "1.6 - 2.5", text: "فهم مقبول للمهام مع الحاجة للتوضيح" },
                    high: { range: "2.6 - 4.0", text: "فهم شامل للمهام والمسؤوليات" },
                    excellent: { range: "4.1 - 5.0", text: "فهم متميز وقدرة على تدريب الآخرين" }
                }
            }
        ]
    },
    work_quality: {
        title: "معايير جودة العمل",
        criteria: [
            {
                name: "الدقة في تنفيذ المهام",
                descriptions: {
                    low: { range: "0 - 1.5", text: "أخطاء متكررة تحتاج تصحيح مستمر" },
                    medium: { range: "1.6 - 2.5", text: "دقة مقبولة مع بعض الأخطاء البسيطة" },
                    high: { range: "2.6 - 4.0", text: "دقة عالية مع أخطاء نادرة" },
                    excellent: { range: "4.1 - 5.0", text: "دقة استثنائية وجودة نموذجية" }
                }
            },
            {
                name: "الالتزام بالمعايير والضوابط",
                descriptions: {
                    low: { range: "0 - 1.5", text: "التزام ضعيف بالمعايير المطلوبة" },
                    medium: { range: "1.6 - 2.5", text: "التزام متوسط مع بعض التجاوزات" },
                    high: { range: "2.6 - 4.0", text: "التزام جيد بالمعايير والضوابط" },
                    excellent: { range: "4.1 - 5.0", text: "التزام نموذجي وتطوير للمعايير" }
                }
            },
            {
                name: "التنظيم وترتيب الأولويات",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ضعف في التنظيم وتحديد الأولويات" },
                    medium: { range: "1.6 - 2.5", text: "تنظيم مقبول مع حاجة للتوجيه" },
                    high: { range: "2.6 - 4.0", text: "تنظيم جيد وترتيب فعال للأولويات" },
                    excellent: { range: "4.1 - 5.0", text: "تنظيم ممتاز وإدارة مثالية للأولويات" }
                }
            },
            {
                name: "الاهتمام بالتفاصيل",
                descriptions: {
                    low: { range: "0 - 1.5", text: "إهمال للتفاصيل المهمة" },
                    medium: { range: "1.6 - 2.5", text: "اهتمام مقبول بالتفاصيل الأساسية" },
                    high: { range: "2.6 - 4.0", text: "اهتمام جيد بالتفاصيل الدقيقة" },
                    excellent: { range: "4.1 - 5.0", text: "دقة استثنائية في متابعة التفاصيل" }
                }
            }
        ]
    },
    productivity: {
        title: "معايير الإنتاجية",
        criteria: [
            {
                name: "كمية العمل المنجز",
                descriptions: {
                    low: { range: "0 - 1.5", text: "إنجاز محدود للمهام المطلوبة" },
                    medium: { range: "1.6 - 2.5", text: "إنجاز مقبول للمهام الأساسية" },
                    high: { range: "2.6 - 4.0", text: "إنجاز جيد يفوق المتوقع" },
                    excellent: { range: "4.1 - 5.0", text: "إنجاز استثنائي يتجاوز المعايير" }
                }
            },
            {
                name: "سرعة الإنجاز",
                descriptions: {
                    low: { range: "0 - 1.5", text: "بطء ملحوظ في إنجاز المهام" },
                    medium: { range: "1.6 - 2.5", text: "سرعة مقبولة في الإنجاز" },
                    high: { range: "2.6 - 4.0", text: "سرعة جيدة تلبي المتطلبات" },
                    excellent: { range: "4.1 - 5.0", text: "سرعة ممتازة مع جودة عالية" }
                }
            },
            {
                name: "إدارة الوقت",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ضعف في إدارة الوقت والمواعيد" },
                    medium: { range: "1.6 - 2.5", text: "إدارة مقبولة للوقت" },
                    high: { range: "2.6 - 4.0", text: "إدارة جيدة للوقت والمهام" },
                    excellent: { range: "4.1 - 5.0", text: "إدارة مثالية للوقت والأولويات" }
                }
            },
            {
                name: "تحقيق الأهداف المحددة",
                descriptions: {
                    low: { range: "0 - 1.5", text: "صعوبة في تحقيق الأهداف" },
                    medium: { range: "1.6 - 2.5", text: "تحقيق مقبول للأهداف الأساسية" },
                    high: { range: "2.6 - 4.0", text: "تحقيق جيد للأهداف المحددة" },
                    excellent: { range: "4.1 - 5.0", text: "تحقيق متميز يتجاوز الأهداف" }
                }
            }
        ]
    },
    communication: {
        title: "معايير التواصل",
        criteria: [
            {
                name: "مهارات التواصل الشفهي",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ضعف في التواصل الشفهي" },
                    medium: { range: "1.6 - 2.5", text: "تواصل شفهي مقبول" },
                    high: { range: "2.6 - 4.0", text: "تواصل شفهي جيد وفعال" },
                    excellent: { range: "4.1 - 5.0", text: "تواصل شفهي متميز ومؤثر" }
                }
            },
            {
                name: "مهارات التواصل الكتابي",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ضعف في التواصل الكتابي" },
                    medium: { range: "1.6 - 2.5", text: "تواصل كتابي مقبول" },
                    high: { range: "2.6 - 4.0", text: "تواصل كتابي جيد وواضح" },
                    excellent: { range: "4.1 - 5.0", text: "تواصل كتابي متميز ومهني" }
                }
            },
            {
                name: "الإصغاء الفعال",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ضعف في الإصغاء والفهم" },
                    medium: { range: "1.6 - 2.5", text: "إصغاء مقبول مع بعض الفجوات" },
                    high: { range: "2.6 - 4.0", text: "إصغاء جيد وفهم للمحتوى" },
                    excellent: { range: "4.1 - 5.0", text: "إصغاء ممتاز وفهم عميق" }
                }
            },
            {
                name: "وضوح وفعالية التواصل",
                descriptions: {
                    low: { range: "0 - 1.5", text: "غموض وعدم فعالية في التواصل" },
                    medium: { range: "1.6 - 2.5", text: "وضوح مقبول في التواصل" },
                    high: { range: "2.6 - 4.0", text: "تواصل واضح وفعال" },
                    excellent: { range: "4.1 - 5.0", text: "تواصل متميز وتأثير إيجابي" }
                }
            }
        ]
    },
    teamwork: {
        title: "معايير العمل الجماعي",
        criteria: [
            {
                name: "التعاون مع الزملاء",
                descriptions: {
                    low: { range: "0 - 1.5", text: "صعوبة في التعاون مع الزملاء" },
                    medium: { range: "1.6 - 2.5", text: "تعاون مقبول مع الزملاء" },
                    high: { range: "2.6 - 4.0", text: "تعاون جيد وبناء مع الزملاء" },
                    excellent: { range: "4.1 - 5.0", text: "تعاون متميز وتأثير إيجابي على الفريق" }
                }
            },
            {
                name: "المشاركة في العمل الجماعي",
                descriptions: {
                    low: { range: "0 - 1.5", text: "مشاركة محدودة في العمل الجماعي" },
                    medium: { range: "1.6 - 2.5", text: "مشاركة مقبولة في المهام الجماعية" },
                    high: { range: "2.6 - 4.0", text: "مشاركة فعالة في العمل الجماعي" },
                    excellent: { range: "4.1 - 5.0", text: "مشاركة متميزة وقيادة للفريق" }
                }
            },
            {
                name: "احترام آراء الآخرين",
                descriptions: {
                    low: { range: "0 - 1.5", text: "صعوبة في تقبل آراء الآخرين" },
                    medium: { range: "1.6 - 2.5", text: "احترام مقبول لآراء الزملاء" },
                    high: { range: "2.6 - 4.0", text: "احترام جيد وتقدير لآراء الآخرين" },
                    excellent: { range: "4.1 - 5.0", text: "احترام متميز وتشجيع لتنوع الآراء" }
                }
            },
            {
                name: "دعم روح الفريق",
                descriptions: {
                    low: { range: "0 - 1.5", text: "مساهمة ضعيفة في روح الفريق" },
                    medium: { range: "1.6 - 2.5", text: "مساهمة مقبولة في روح الفريق" },
                    high: { range: "2.6 - 4.0", text: "مساهمة إيجابية في روح الفريق" },
                    excellent: { range: "4.1 - 5.0", text: "مساهمة متميزة في تعزيز روح الفريق" }
                }
            }
        ]
    },
    initiative: {
        title: "معايير المبادرة",
        criteria: [
            {
                name: "تقديم الأفكار والحلول",
                descriptions: {
                    low: { range: "0 - 1.5", text: "نادراً ما يقدم أفكار أو حلول" },
                    medium: { range: "1.6 - 2.5", text: "يقدم أفكار وحلول بسيطة" },
                    high: { range: "2.6 - 4.0", text: "يقدم أفكار وحلول مبتكرة" },
                    excellent: { range: "4.1 - 5.0", text: "يقدم أفكار وحلول متميزة ومبدعة" }
                }
            },
            {
                name: "المبادرة في تحمل المسؤوليات",
                descriptions: {
                    low: { range: "0 - 1.5", text: "يتجنب تحمل مسؤوليات إضافية" },
                    medium: { range: "1.6 - 2.5", text: "يتحمل المسؤوليات عند الطلب" },
                    high: { range: "2.6 - 4.0", text: "يبادر في تحمل مسؤوليات إضافية" },
                    excellent: { range: "4.1 - 5.0", text: "يسعى باستمرار لتحمل مسؤوليات جديدة" }
                }
            },
            {
                name: "الاستباقية في حل المشكلات",
                descriptions: {
                    low: { range: "0 - 1.5", text: "ينتظر توجيهات لحل المشكلات" },
                    medium: { range: "1.6 - 2.5", text: "يحل المشكلات البسيطة باستقلالية" },
                    high: { range: "2.6 - 4.0", text: "يتوقع ويحل المشكلات قبل تفاقمها" },
                    excellent: { range: "4.1 - 5.0", text: "يضع خطط استباقية لمنع المشكلات" }
                }
            },
            {
                name: "التطوير الذاتي",
                descriptions: {
                    low: { range: "0 - 1.5", text: "اهتمام محدود بالتطوير الذاتي" },
                    medium: { range: "1.6 - 2.5", text: "يشارك في برامج التطوير المطلوبة" },
                    high: { range: "2.6 - 4.0", text: "يسعى بنشاط للتطوير الذاتي" },
                    excellent: { range: "4.1 - 5.0", text: "يبادر ويقود جهود التطوير الذاتي" }
                }
            }
        ]
    },
    dependability: {
        title: "معايير الاعتمادية",
        criteria: [
            {
                name: "الالتزام بالمواعيد",
                descriptions: {
                    low: { range: "0 - 1.5", text: "تأخير متكرر وعدم التزام بالمواعيد" },
                    medium: { range: "1.6 - 2.5", text: "التزام مقبول بالمواعيد الأساسية" },
                    high: { range: "2.6 - 4.0", text: "التزام جيد بالمواعيد والجداول" },
                    excellent: { range: "4.1 - 5.0", text: "التزام مثالي وإدارة محترفة للوقت" }
                }
            },
            {
                name: "تحمل المسؤولية",
                descriptions: {
                    low: { range: "0 - 1.5", text: "تردد في تحمل المسؤولية عن الأخطاء" },
                    medium: { range: "1.6 - 2.5", text: "يتحمل المسؤولية عند المساءلة" },
                    high: { range: "2.6 - 4.0", text: "يتحمل المسؤولية بشكل استباقي" },
                    excellent: { range: "4.1 - 5.0", text: "يتحمل المسؤولية الكاملة ويعالج النتائج" }
                }
            },
            {
                name: "الموثوقية في إنجاز المهام",
                descriptions: {
                    low: { range: "0 - 1.5", text: "غير موثوق في إنجاز المهام" },
                    medium: { range: "1.6 - 2.5", text: "موثوق في المهام الروتينية" },
                    high: { range: "2.6 - 4.0", text: "موثوق في المهام المعقدة" },
                    excellent: { range: "4.1 - 5.0", text: "موثوق بشكل استثنائي في كل الظروف" }
                }
            },
            {
                name: "القيادة في العمل",
                descriptions: {
                    low: { range: "0 - 1.5", text: "يتجنب أخذ دور قيادي" },
                    medium: { range: "1.6 - 2.5", text: "يقود عند الطلب" },
                    high: { range: "2.6 - 4.0", text: "يظهر مهارات قيادية جيدة" },
                    excellent: { range: "4.1 - 5.0", text: "قيادة متميزة وتأثير إيجابي" }
                }
            }
        ]
    }
};
    // Global object to track criteria scores
let criteriaScores = {};

function updateCriteriaDescription(metric, criteriaIndex, value) {
    const descriptions = CRITERIA_CONFIG[metric].criteria[criteriaIndex].descriptions;
    let description = '';
    
    if (value <= 1.5) {
        description = descriptions.low;
    } else if (value <= 2.5) {
        description = descriptions.medium;
    } else if (value <= 4.0) {
        description = descriptions.high;
    } else {
        description = descriptions.excellent;
    }
    
    const descriptionElement = document.querySelector(`#${metric}Modal .criteria-item:nth-child(${criteriaIndex + 1}) .criteria-description`);
    if (descriptionElement) {
        descriptionElement.textContent = `${description.range}: ${description.text}`;
    }
}

// Update the openMetricModal function
window.openMetricModal = function(metric) {
    const modal = document.getElementById(`${metric}Modal`);
    if (!modal) return;

    if (!criteriaScores[metric]) {
        criteriaScores[metric] = {};
        CRITERIA_CONFIG[metric].criteria.forEach((_, index) => {
            criteriaScores[metric][index] = 0;
        });
    }

    const ranges = modal.querySelectorAll('.criteria-range');
    ranges.forEach((range, index) => {
        range.value = criteriaScores[metric][index] || 0;
        updateCriteriaValue(range);
        updateCriteriaDescription(metric, index, range.value);
        
        range.addEventListener('input', function() {
            updateCriteriaValue(this);
            updateCriteriaDescription(metric, index, this.value);
        });
    });

    modal.style.display = 'block';
};

// Function to close a metric modal
function closeMetricModal(metric) {
    const modal = document.getElementById(`${metric}Modal`);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Function to update criteria value display
function updateCriteriaValue(rangeInput) {
    const valueDisplay = rangeInput.nextElementSibling;
    if (valueDisplay) {
        valueDisplay.textContent = parseFloat(rangeInput.value).toFixed(1);
    }
}

// Apply scores to the main metric and calculate the average
window.applyMetricScores = function(metric) {
    const modal = document.getElementById(`${metric}Modal`);
    if (!modal) return;

    const ranges = modal.querySelectorAll('.criteria-range');
    let total = 0;

    ranges.forEach((range, index) => {
        const value = parseFloat(range.value);
        criteriaScores[metric][index] = value;
        total += value;
    });

    const average = total / ranges.length;
    
    const mainScoreInput = document.getElementById(metric);
    const mainScoreDisplay = mainScoreInput.nextElementSibling;
    
    mainScoreInput.value = average.toFixed(1);
    mainScoreDisplay.textContent = average.toFixed(1);

    closeMetricModal(metric);
};

// Update individual score display
window.updateScore = function(slider) {
    if (!slider) return;
    
    const value = parseFloat(slider.value).toFixed(1);
    const ratingGroup = slider.closest('.rating-group');
    
    if (ratingGroup) {
        const scoreValueElement = ratingGroup.querySelector('.score-value');
        if (scoreValueElement) {
            scoreValueElement.textContent = value;
        }
    }
};

// Initialize range sliders
document.addEventListener('DOMContentLoaded', function() {
    const rangeInputs = document.querySelectorAll('.score-card input[type="range"]');
    if (rangeInputs.length > 0) {
        rangeInputs.forEach(slider => {
            slider.addEventListener('input', function() {
                window.updateScore(this);
            });
            window.updateScore(slider);
        });
    }
});

// Close modal functionality
document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function() {
        const modal = this.closest('.modal');
        if (modal) {
            modal.style.display = 'none';
        }
    });
});

// Update close and button behavior
document.querySelectorAll('.close, .btn-primary').forEach(button => {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        if (modal) {
            modal.style.display = 'none';
        }
    });
});

// Update criteria range inputs
document.querySelectorAll('.criteria-range').forEach(range => {
    range.addEventListener('input', function() {
        const valueDisplay = this.nextElementSibling;
        if (valueDisplay) {
            valueDisplay.textContent = parseFloat(this.value).toFixed(1);
        }
    });
});

// Close modal on background click
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

// Updated form validation function
function validateForm() {
    let isValid = true;
    let firstError = null;
    let errorMessages = [];

    // Check required fields
    document.querySelectorAll('[required]').forEach(field => {
        const label = field.previousElementSibling;
        const fieldName = label ? label.textContent : field.name;
        
        if (!field.value || field.value.trim() === '') {
            isValid = false;
            firstError = firstError || field;
            errorMessages.push(`الحقل "${fieldName}" مطلوب`);
        }
    });

    // Check performance scores
    const scores = {
        job_knowledge: document.getElementById('job_knowledge')?.value,
        work_quality: document.getElementById('work_quality')?.value,
        productivity: document.getElementById('productivity')?.value,
        communication: document.getElementById('communication')?.value,
        teamwork: document.getElementById('teamwork')?.value,
        initiative: document.getElementById('initiative')?.value,
        dependability: document.getElementById('dependability')?.value
    };

    Object.entries(scores).forEach(([key, value]) => {
        const numericValue = parseFloat(value);
        if (isNaN(numericValue) || numericValue === 0) {
            const scoreCard = document.getElementById(key)?.closest('.score-card');
            const label = scoreCard?.querySelector('label') || { textContent: key };
            const scoreName = label.textContent || key;

            isValid = false;
            firstError = firstError || document.getElementById(key);
            errorMessages.push(`الرجاء تحديد تقييم "${scoreName}"`);
        }
    });

    if (!isValid) {
        Swal.fire({
            title: 'تنبيه!',
            html: errorMessages.join('<br>'),
            icon: 'warning',
            confirmButtonText: 'حسناً',
            confirmButtonColor: '#2563eb'
        });
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus({ preventScroll: true });
        }
    }
    return isValid;
}

 // 3. Form submission logic
 form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        Swal.fire({
            title: 'جاري الحفظ...',
            html: 'الرجاء الانتظار',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(this);
        formData.append('evaluator_id', '<?php echo $_SESSION['user_id']; ?>');
        formData.append('evaluator_department', userDepartment);

        const userSquadron = '<?php echo $_SESSION['user_squadron'] ?? ''; ?>';
        const baseValue = formData.get('department');

        // Adjust department / SQUADRONS for squadron users or admin selection
        if (userSquadron) {
            formData.set('department', userDepartment);
            formData.set('squadron', userSquadron);
        } else if (baseValue.includes(' - ')) {
            const [base, squadron] = baseValue.split(' - ');
            formData.set('department', base);
            formData.set('squadron', squadron);
        } else {
            formData.set('department', userDepartment);
            formData.set('squadron', '');
        }

        // Double-check if department includes squadron data or isSquadron is true
        const departmentValue = formData.get('department');
        if (departmentValue.includes(' - ')) {
            const [base, squadron] = departmentValue.split(' - ');
            formData.set('department', base);
            formData.set('squadron', squadron);
        } else if (typeof isSquadron !== 'undefined' && isSquadron) {
            const [base, squadron] = userDepartment.split(' - ');
            formData.set('department', base);
            formData.set('squadron', squadron);
        } else {
            formData.set('squadron', '');
        }

        fetch('save_evaluation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'تم الحفظ بنجاح',
                    text: 'تم حفظ التقييم بنجاح',
                    icon: 'success',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#2563eb',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = 'evaluations.php';
                });
            } else {
                Swal.fire({
                    title: 'خطأ!',
                    text: data.message || 'حدث خطأ أثناء حفظ التقييم',
                    icon: 'error',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc2626'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'خطأ!',
                text: 'حدث خطأ أثناء حفظ التقييم',
                icon: 'error',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#dc2626'
            });
        });
    });

function showError(field, message) {
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = 'var(--danger-color)';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
    field.classList.add('error');
}

});
</script>

<style>
.criteria-item {
    margin: 1.5rem 0;
    padding: 1.5rem;
    background: var(--background-color);
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
}

.criteria-input-group {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1rem 0;
}

.criteria-ranges {
    margin-top: 1rem;
    font-size: 0.875rem;
}

.range-item {
    padding: 0.5rem;
    margin: 0.25rem 0;
    border-radius: 0.25rem;
    transition: background-color 0.2s;
}

.range-item.low {
    color: #dc2626;
}

.range-item.medium {
    color: #d97706;
}

.range-item.high {
    color: #059669;
}

.range-item.excellent {
    color: #1d4ed8;
}

.range-item.active {
    background-color: #f3f4f6;
    font-weight: 600;
}

.criteria-value {
    min-width: 3rem;
    text-align: center;
    font-weight: 600;
    color: var(--primary-color);
}

input[type="range"] {
    flex-grow: 1;
    height: 6px;
    background: var(--border-color);
    border-radius: 3px;
    outline: none;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
}
</style>

<!-- المعرفة الوظيفية -->
<div id="job_knowledgeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير المعرفة الوظيفية</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>فهم الإجراءات وأنظمة العمل</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: يحتاج إلى إشراف مستمر لفهم الإجراءات والأنظمة الأساسية</div>
                    <div class="range-item medium">1.6 - 2.5: يظهر فهماً أساسياً للإجراءات والأنظمة مع الحاجة للتوجيه أحياناً</div>
                    <div class="range-item high">2.6 - 4.0: لديه إلمام جيد في الإجراءات والأنظمة ويطبقها باستقلالية</div>
                    <div class="range-item excellent">4.1 - 5.0: متميز في فهم وتحليل وتطوير الإجراءات والأنظمة</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>المعرفة بالقوانين واللوائح العسكرية</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: معرفة محدودة بالقوانين واللوائح الأساسية</div>
                    <div class="range-item medium">1.6 - 2.5: معرفة مقبولة بالقوانين واللوائح مع بعض الثغرات</div>
                    <div class="range-item high">2.6 - 4.0: معرفة شاملة بالقوانين واللوائح وتطبيقاتها</div>
                    <div class="range-item excellent">4.1 - 5.0: خبير في القوانين واللوائح ومرجع للآخرين</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>القدرة على تطبيق المعرفة في العمل</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: صعوبة في تطبيق المعرفة النظرية عملياً</div>
                    <div class="range-item medium">1.6 - 2.5: يطبق المعرفة الأساسية بشكل مقبول</div>
                    <div class="range-item high">2.6 - 4.0: يطبق المعرفة بكفاءة في مختلف المواقف</div>
                    <div class="range-item excellent">4.1 - 5.0: يبتكر طرقاً جديدة لتطبيق المعرفة وتحسين العمل</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الإلمام بالمهام والمسؤوليات</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: فهم محدود للمهام والمسؤوليات</div>
                    <div class="range-item medium">1.6 - 2.5: فهم مقبول للمهام مع الحاجة للتوضيح</div>
                    <div class="range-item high">2.6 - 4.0: فهم شامل للمهام والمسؤوليات</div>
                    <div class="range-item excellent">4.1 - 5.0: فهم متميز وقدرة على تدريب الآخرين</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('job_knowledge')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<!-- جودة العمل -->
<div id="work_qualityModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير جودة العمل</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>الدقة في تنفيذ المهام</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: أخطاء متكررة تحتاج تصحيح مستمر</div>
                    <div class="range-item medium">1.6 - 2.5: دقة مقبولة مع بعض الأخطاء البسيطة</div>
                    <div class="range-item high">2.6 - 4.0: دقة عالية مع أخطاء نادرة</div>
                    <div class="range-item excellent">4.1 - 5.0: دقة استثنائية وجودة نموذجية</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الالتزام بالمعايير والضوابط</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: التزام ضعيف بالمعايير المطلوبة</div>
                    <div class="range-item medium">1.6 - 2.5: التزام متوسط مع بعض التجاوزات</div>
                    <div class="range-item high">2.6 - 4.0: التزام جيد بالمعايير والضوابط</div>
                    <div class="range-item excellent">4.1 - 5.0: التزام نموذجي وتطوير للمعايير</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>التنظيم وترتيب الأولويات</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ضعف في التنظيم وتحديد الأولويات</div>
                    <div class="range-item medium">1.6 - 2.5: تنظيم مقبول مع حاجة للتوجيه</div>
                    <div class="range-item high">2.6 - 4.0: تنظيم جيد وترتيب فعال للأولويات</div>
                    <div class="range-item excellent">4.1 - 5.0: تنظيم ممتاز وإدارة مثالية للأولويات</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الاهتمام بالتفاصيل</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: إهمال للتفاصيل المهمة</div>
                    <div class="range-item medium">1.6 - 2.5: اهتمام مقبول بالتفاصيل الأساسية</div>
                    <div class="range-item high">2.6 - 4.0: اهتمام جيد بالتفاصيل الدقيقة</div>
                    <div class="range-item excellent">4.1 - 5.0: دقة استثنائية في متابعة التفاصيل</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('work_quality')" class="btn btn-primary">تطبيق</button>
    </div>
</div>
<!-- الإنتاجية -->
<div id="productivityModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير الإنتاجية</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>كمية العمل المنجز</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: إنجاز محدود للمهام المطلوبة</div>
                    <div class="range-item medium">1.6 - 2.5: إنجاز مقبول للمهام الأساسية</div>
                    <div class="range-item high">2.6 - 4.0: إنجاز جيد يفوق المتوقع</div>
                    <div class="range-item excellent">4.1 - 5.0: إنجاز استثنائي يتجاوز المعايير</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>سرعة الإنجاز</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: بطء ملحوظ في إنجاز المهام</div>
                    <div class="range-item medium">1.6 - 2.5: سرعة مقبولة في الإنجاز</div>
                    <div class="range-item high">2.6 - 4.0: سرعة جيدة تلبي المتطلبات</div>
                    <div class="range-item excellent">4.1 - 5.0: سرعة ممتازة مع جودة عالية</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>إدارة الوقت</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ضعف في إدارة الوقت والمواعيد</div>
                    <div class="range-item medium">1.6 - 2.5: إدارة مقبولة للوقت</div>
                    <div class="range-item high">2.6 - 4.0: إدارة جيدة للوقت والمهام</div>
                    <div class="range-item excellent">4.1 - 5.0: إدارة مثالية للوقت والأولويات</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>تحقيق الأهداف المحددة</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: صعوبة في تحقيق الأهداف</div>
                    <div class="range-item medium">1.6 - 2.5: تحقيق مقبول للأهداف الأساسية</div>
                    <div class="range-item high">2.6 - 4.0: تحقيق جيد للأهداف المحددة</div>
                    <div class="range-item excellent">4.1 - 5.0: تحقيق متميز يتجاوز الأهداف</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('productivity')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<!-- التواصل -->
<div id="communicationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير التواصل</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>مهارات التواصل الشفهي</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ضعف في التواصل الشفهي</div>
                    <div class="range-item medium">1.6 - 2.5: تواصل شفهي مقبول</div>
                    <div class="range-item high">2.6 - 4.0: تواصل شفهي جيد وفعال</div>
                    <div class="range-item excellent">4.1 - 5.0: تواصل شفهي متميز ومؤثر</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>مهارات التواصل الكتابي</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ضعف في التواصل الكتابي</div>
                    <div class="range-item medium">1.6 - 2.5: تواصل كتابي مقبول</div>
                    <div class="range-item high">2.6 - 4.0: تواصل كتابي جيد وواضح</div>
                    <div class="range-item excellent">4.1 - 5.0: تواصل كتابي متميز ومهني</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الإصغاء الفعال</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ضعف في الإصغاء والفهم</div>
                    <div class="range-item medium">1.6 - 2.5: إصغاء مقبول مع بعض الفجوات</div>
                    <div class="range-item high">2.6 - 4.0: إصغاء جيد وفهم للمحتوى</div>
                    <div class="range-item excellent">4.1 - 5.0: إصغاء ممتاز وفهم عميق</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>وضوح وفعالية التواصل</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: غموض وعدم فعالية في التواصل</div>
                    <div class="range-item medium">1.6 - 2.5: وضوح مقبول في التواصل</div>
                    <div class="range-item high">2.6 - 4.0: تواصل واضح وفعال</div>
                    <div class="range-item excellent">4.1 - 5.0: تواصل متميز وتأثير إيجابي</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('communication')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<!-- العمل الجماعي -->
<div id="teamworkModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير العمل الجماعي</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>التعاون مع الزملاء</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: صعوبة في التعاون مع الزملاء</div>
                    <div class="range-item medium">1.6 - 2.5: تعاون مقبول مع الزملاء</div>
                    <div class="range-item high">2.6 - 4.0: تعاون جيد وبناء مع الزملاء</div>
                    <div class="range-item excellent">4.1 - 5.0: تعاون متميز وتأثير إيجابي</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>المشاركة في العمل الجماعي</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: مشاركة محدودة في العمل الجماعي</div>
                    <div class="range-item medium">1.6 - 2.5: مشاركة مقبولة في المهام الجماعية</div>
                    <div class="range-item high">2.6 - 4.0: مشاركة فعالة في العمل الجماعي</div>
                    <div class="range-item excellent">4.1 - 5.0: مشاركة متميزة وقيادة للفريق</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>احترام آراء الآخرين</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: صعوبة في تقبل آراء الآخرين</div>
                    <div class="range-item medium">1.6 - 2.5: احترام مقبول لآراء الزملاء</div>
                    <div class="range-item high">2.6 - 4.0: احترام جيد وتقدير لآراء الآخرين</div>
                    <div class="range-item excellent">4.1 - 5.0: احترام متميز وتشجيع لتنوع الآراء</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>دعم روح الفريق</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: مساهمة ضعيفة في روح الفريق</div>
                    <div class="range-item medium">1.6 - 2.5: مساهمة مقبولة في روح الفريق</div>
                    <div class="range-item high">2.6 - 4.0: مساهمة إيجابية في روح الفريق</div>
                    <div class="range-item excellent">4.1 - 5.0: مساهمة متميزة في تعزيز روح الفريق</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('teamwork')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<!-- المبادرة -->
<div id="initiativeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير المبادرة</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>تقديم الأفكار والحلول</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: نادراً ما يقدم أفكار أو حلول</div>
                    <div class="range-item medium">1.6 - 2.5: يقدم أفكار وحلول بسيطة</div>
                    <div class="range-item high">2.6 - 4.0: يقدم أفكار وحلول مبتكرة</div>
                    <div class="range-item excellent">4.1 - 5.0: يقدم أفكار وحلول متميزة ومبدعة</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>المبادرة في تحمل المسؤوليات</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: يتجنب تحمل مسؤوليات إضافية</div>
                    <div class="range-item medium">1.6 - 2.5: يتحمل المسؤوليات عند الطلب</div>
                    <div class="range-item high">2.6 - 4.0: يبادر في تحمل مسؤوليات إضافية</div>
                    <div class="range-item excellent">4.1 - 5.0: يسعى باستمرار لتحمل مسؤوليات جديدة</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الاستباقية في حل المشكلات</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: ينتظر توجيهات لحل المشكلات</div>
                    <div class="range-item medium">1.6 - 2.5: يحل المشكلات البسيطة باستقلالية</div>
                    <div class="range-item high">2.6 - 4.0: يتوقع ويحل المشكلات قبل تفاقمها</div>
                    <div class="range-item excellent">4.1 - 5.0: يضع خطط استباقية لمنع المشكلات</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>التطوير الذاتي</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: اهتمام محدود بالتطوير الذاتي</div>
                    <div class="range-item medium">1.6 - 2.5: يشارك في برامج التطوير المطلوبة</div>
                    <div class="range-item high">2.6 - 4.0: يسعى بنشاط للتطوير الذاتي</div>
                    <div class="range-item excellent">4.1 - 5.0: يبادر ويقود جهود التطوير الذاتي</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('initiative')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<!-- الاعتمادية -->
<div id="dependabilityModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>معايير الاعتمادية</h2>
        <div class="criteria-container">
            <div class="criteria-item">
                <label>الالتزام بالمواعيد</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: تأخير متكرر وعدم التزام بالمواعيد</div>
                    <div class="range-item medium">1.6 - 2.5: التزام مقبول بالمواعيد الأساسية</div>
                    <div class="range-item high">2.6 - 4.0: التزام جيد بالمواعيد والجداول</div>
                    <div class="range-item excellent">4.1 - 5.0: التزام مثالي وإدارة محترفة للوقت</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>تحمل المسؤولية</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: تردد في تحمل المسؤولية عن الأخطاء</div>
                    <div class="range-item medium">1.6 - 2.5: يتحمل المسؤولية عند المساءلة</div>
                    <div class="range-item high">2.6 - 4.0: يتحمل المسؤولية بشكل استباقي</div>
                    <div class="range-item excellent">4.1 - 5.0: يتحمل المسؤولية الكاملة ويعالج النتائج</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>الموثوقية في إنجاز المهام</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: غير موثوق في إنجاز المهام</div>
                    <div class="range-item medium">1.6 - 2.5: موثوق في المهام الروتينية</div>
                    <div class="range-item high">2.6 - 4.0: موثوق في المهام المعقدة</div>
                    <div class="range-item excellent">4.1 - 5.0: موثوق بشكل استثنائي في كل الظروف</div>
                </div>
            </div>

            <div class="criteria-item">
                <label>القيادة في العمل</label>
                <div class="criteria-input-group">
                    <input type="range" class="criteria-range" min="0" max="5" step="0.1" value="0">
                    <span class="criteria-value">0.0</span>
                </div>
                <div class="criteria-ranges">
                    <div class="range-item low">0 - 1.5: يتجنب أخذ دور قيادي</div>
                    <div class="range-item medium">1.6 - 2.5: يقود عند الطلب</div>
                    <div class="range-item high">2.6 - 4.0: يظهر مهارات قيادية جيدة</div>
                    <div class="range-item excellent">4.1 - 5.0: قيادة متميزة وتأثير إيجابي</div>
                </div>
            </div>
        </div>
        <button onclick="applyMetricScores('dependability')" class="btn btn-primary">تطبيق</button>
    </div>
</div>

<script>
// Update the range description based on the current value
function updateRangeDescription(criteriaItem, value) {
    const ranges = criteriaItem.querySelectorAll('.range-item');
    ranges.forEach(range => range.classList.remove('active'));
    
    if (value <= 1.5) {
        criteriaItem.querySelector('.range-item.low').classList.add('active');
    } else if (value <= 2.5) {
        criteriaItem.querySelector('.range-item.medium').classList.add('active');
    } else if (value <= 4.0) {
        criteriaItem.querySelector('.range-item.high').classList.add('active');
    } else {
        criteriaItem.querySelector('.range-item.excellent').classList.add('active');
    }
}

// Initialize event listeners for all range inputs
document.querySelectorAll('.criteria-range').forEach(range => {
    range.addEventListener('input', function() {
        const criteriaItem = this.closest('.criteria-item');
        const value = parseFloat(this.value);
        updateRangeDescription(criteriaItem, value);
        
        const valueDisplay = criteriaItem.querySelector('.criteria-value');
        if (valueDisplay) {
            valueDisplay.textContent = value.toFixed(1);
        }
    });
});
</script>

<style>
/* Modal Container Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    overflow: hidden;
}

.modal-content {
    background-color: var(--surface-color);
    position: relative;
    margin: 2% auto;
    width: 90%;
    max-width: 800px;
    max-height: 95vh;
    border-radius: 0.75rem;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Modal Header */
.modal-header {
    padding: 1.5rem 2rem;
    background-color: var(--surface-color);
    border-bottom: 1px solid var(--border-color);
    border-radius: 0.75rem 0.75rem 0 0;
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Scrollable Container */
.criteria-container {
    padding: 1.5rem 2rem;
    overflow-y: auto;
    max-height: calc(95vh - 140px); /* Adjust based on header and footer height */
}

/* Modal Footer */
.modal-footer {
    padding: 1rem 2rem;
    background-color: var(--surface-color);
    border-top: 1px solid var(--border-color);
    border-radius: 0 0 0.75rem 0.75rem;
    position: sticky;
    bottom: 0;
    z-index: 10;
    text-align: left;
}

/* Close Button */
.close {
    position: absolute;
    left: 1.5rem;
    top: 1.5rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--text-secondary);
    cursor: pointer;
    z-index: 11;
}

/* Ensure content is properly spaced */
.criteria-item {
    margin-bottom: 1.5rem;
    background: var(--background-color);
    padding: 1.5rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
}

.criteria-item:last-child {
    margin-bottom: 0.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-content {
        margin: 0;
        width: 100%;
        height: 100%;
        max-height: 100vh;
        border-radius: 0;
    }
    
    .criteria-container {
        max-height: calc(100vh - 140px);
    }
    
    .modal-header,
    .modal-footer {
        border-radius: 0;
    }
}
</style>

<style>
.criteria-ranges {
    margin-top: 1rem !important;
    font-size: 0.875rem !important;
}

.range-item {
    padding: 0.75rem !important;
    margin: 0.25rem 0 !important;
    border-radius: 0.375rem !important;
    transition: all 0.2s ease-in-out !important;
}

/* Base colors for different ranges */
.range-item.low {
    color: #dc2626 !important;
    border-right: 3px solid #dc2626 !important;
}

.range-item.medium {
    color: #d97706 !important;
    border-right: 3px solid #d97706 !important;
}

.range-item.high {
    color: #059669 !important;
    border-right: 3px solid #059669 !important;
}

.range-item.excellent {
    color: #1d4ed8 !important;
    border-right: 3px solid #1d4ed8 !important;
}

/* Highlighted active states */
.range-item.low.active {
    background-color: rgba(220, 38, 38, 0.1) !important;
    color: #dc2626 !important;
}

.range-item.medium.active {
    background-color: rgba(217, 119, 6, 0.1) !important;
    color: #d97706 !important;
}

.range-item.high.active {
    background-color: rgba(5, 150, 105, 0.1) !important;
    color: #059669 !important;
}

.range-item.excellent.active {
    background-color: rgba(29, 78, 216, 0.1) !important;
    color: #1d4ed8 !important;
}

/* Hover effects for better interactivity */
.range-item:hover {
    background-color: #f3f4f6 !important;
}

/* Update criteria input group styles */
.criteria-input-group {
    display: flex !important;
    align-items: center !important;
    gap: 1rem !important;
    margin: 1rem 0 !important;
    padding: 0.5rem !important;
    background-color: #f8fafc !important;
    border-radius: 0.5rem !important;
}

.criteria-value {
    min-width: 3rem !important;
    text-align: center !important;
    font-weight: 600 !important;
    color: var(--primary-color) !important;
    padding: 0.25rem 0.5rem !important;
    background-color: white !important;
    border-radius: 0.25rem !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
}

/* Modal scroll styles */
.modal {
    display: none;
    position: fixed !important;
    z-index: 1000 !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background-color: rgba(0,0,0,0.4) !important;
    overflow: hidden !important;
}

.modal-content {
    background-color: var(--surface-color) !important;
    position: relative !important;
    margin: 2% auto !important;
    width: 90% !important;
    max-width: 800px !important;
    max-height: 95vh !important;
    border-radius: 0.75rem !important;
    display: flex !important;
    flex-direction: column !important;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
}

/* Modal Header */
.modal-header {
    padding: 1.5rem 2rem !important;
    background-color: var(--surface-color) !important;
    border-bottom: 1px solid var(--border-color) !important;
    border-radius: 0.75rem 0.75rem 0 0 !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 10 !important;
}

/* Scrollable Container */
.criteria-container {
    padding: 1.5rem 2rem !important;
    overflow-y: auto !important;
    max-height: calc(95vh - 140px) !important;
}

/* Modal Footer */
.modal-footer {
    padding: 1rem 2rem !important;
    background-color: var(--surface-color) !important;
    border-top: 1px solid var(--border-color) !important;
    border-radius: 0 0 0.75rem 0.75rem !important;
    position: sticky !important;
    bottom: 0 !important;
    z-index: 10 !important;
    text-align: left !important;
}

/* Close Button */
.close {
    position: absolute !important;
    left: 1.5rem !important;
    top: 1.5rem !important;
    font-size: 1.5rem !important;
    font-weight: bold !important;
    color: var(--text-secondary) !important;
    cursor: pointer !important;
    z-index: 11 !important;
}

/* Criteria Item */
.criteria-item {
    margin-bottom: 1.5rem !important;
    background: var(--background-color) !important;
    padding: 1.5rem !important;
    border-radius: 0.5rem !important;
    border: 1px solid var(--border-color) !important;
}

.criteria-item:last-child {
    margin-bottom: 0.5rem !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-content {
        margin: 0 !important;
        width: 100% !important;
        height: 100% !important;
        max-height: 100vh !important;
        border-radius: 0 !important;
    }
    
    .criteria-container {
        max-height: calc(100vh - 140px) !important;
    }
    
    .modal-header,
    .modal-footer {
        border-radius: 0 !important;
    }
}
</style>
