<?php
include_once __DIR__ . '/connect.php';
include_once __DIR__ . '/until.php';
class sql {
     public static function SelectTop10($tableName, $orderColumn , $number) {
    global $conn;
    if (!$conn) return null;
    $sql = "SELECT * FROM $tableName ORDER BY $orderColumn DESC LIMIT $number";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        
        return $rows;
    } else {
        return null;
    }
}

public static function SelectTop10Json($tableName, $orderColumn, $index, $number) {
    global $conn;
    if (!$conn) return null;
    
    $sql = "SELECT * FROM $tableName 
            ORDER BY CAST(JSON_EXTRACT($orderColumn, '$[$index]') AS UNSIGNED) DESC 
            LIMIT $number";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        
        return $rows;
    } else {
        return null;
    }
}

     public static function kyTuDacBiet($string) {
         return preg_match('/[^a-zA-Z0-9\s]/', $string);
     }
     
     public static function Select($tableName, $columnName, $columnValue) {
    global $conn;
    if (!$conn) return null;
    $sql = "SELECT * FROM $tableName WHERE $columnName = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $columnValue);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row;
    } else {
        return null;
    }
 }
 
 
 public static function SelectWithIndex($tableName, $columnName, $columnValue, $index) {
    global $conn;
    if (!$conn) return null;
    $sql = "SELECT * FROM $tableName WHERE $columnName = ? LIMIT 1 OFFSET ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $columnValue, $index);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        return null;
    }
}


 
public static function Select1($tableName, $conditions) {
    global $conn;
    if (!$conn) return null;
    try {
        $sql = "SELECT * FROM $tableName WHERE ";
        $types = "";
        $params = [];
        $bindParams = [];

        foreach ($conditions as $columnName => $columnValue) {
            $sql .= "$columnName = ? AND ";
            $types .= 's';
            $params[] = $columnValue;
            $bindParams[] = &$params[count($params) - 1];
        }

        $sql = rtrim($sql, 'AND ');

        if ($stmt = mysqli_prepare($conn, $sql)) {
            array_unshift($bindParams, $stmt, $types); 
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $row;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return null;
    }
}





 
 public static function insert($FROM, $columns, $values) {
    global $conn;
    if (!$conn) return false;
    $stmt = $conn->prepare("INSERT INTO $FROM ($columns) VALUES ($values)");
    $stmt->execute();
    return $conn; 
}



public static function update($tableName, $setColumn, $newValue, $whereColumn, $whereValue) {
    global $conn;
    if (!$conn) return;
    $sql = "UPDATE $tableName SET $setColumn = ? WHERE $whereColumn = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $newValue, $whereValue);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Đã xảy ra lỗi khi chuẩn bị câu lệnh: " . mysqli_error($conn);
    }
}


public static function delete($tableName, $whereColumn, $whereValue) {
    global $conn;
    if (!$conn) return;
    $sql = "DELETE FROM $tableName WHERE $whereColumn = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $whereValue);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Đã xảy ra lỗi khi chuẩn bị câu lệnh: " . mysqli_error($conn);
    }
}

public static function isAdmin() {
  global $conn;
  if (!isset($_SESSION['logger']['username'])){
        return false;
   }
   $account = sql::Select("account" , "username" , $_SESSION['logger']['username']);
   if(!$account){
      return false;
   }
   if($account['is_admin'] == 1){
      return true;
   } else {
      return false;
   }
}

public static function Tong($num , $tableName, $conditions) {

global $conn;
    if (!$conn) return 0;
    try {
        $sql = "SELECT COUNT($num) AS total FROM $tableName WHERE ";
        $types = "";
        $params = [];
        $bindParams = [];

        foreach ($conditions as $columnName => $columnValue) {
            $sql .= "$columnName = ? AND ";
            $types .= 's';
            $params[] = $columnValue;
            $bindParams[] = &$params[count($params) - 1];
        }

        $sql = rtrim($sql, 'AND ');

        if ($stmt = mysqli_prepare($conn, $sql)) {
            array_unshift($bindParams, $stmt, $types); 
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $row['total'];
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return null;
    }
  }
 }
?>