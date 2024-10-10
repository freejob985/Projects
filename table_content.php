<?php
/**
 * محتوى الجدول
 * 
 * يعرض بيانات المواقع في جدول.
 * 
 * @package ProjectManagement
 */

// استعلام لاسترداد البيانات
$stmt = $conn->prepare("SELECT id, site_name, database_, explain_, kind, path, url FROM site_name");
$stmt->execute();

// عرض البيانات في جدول HTML
echo "<table class='table table-bordered table-striped'>
        <thead class='thead-dark'>
            <tr>
                <th>ID</th>
                <th>Site Name</th>
                <th>Database</th>
                <th>Explain</th>
                <th>Kind</th>
                <th>Path</th>
                <th>URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['site_name']}</td>
            <td>{$row['database_']}</td>
            <td>{$row['explain_']}</td>
            <td>{$row['kind']}</td>
            <td>{$row['path']}</td>
            <td><a href='{$row['url']}' target='_blank'>{$row['url']}</a></td>
            <td>
                <form method='POST' action='delete_record.php'> 
                    <input type='hidden' name='record_id' value='{$row['id']}'>
                    <input type='hidden' name='site_name' value='{$row['site_name']}'>
                    <input type='hidden' name='database_' value='{$row['database_']}'>
                    <input type='hidden' name='path' value='{$row['path']}'>
                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                </form>
            </td>
        </tr>";
}

echo "</tbody></table>";