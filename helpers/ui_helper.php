<?php
class UI {	
  public static function CreateMenu($url, $name, $subMenu = [], $icon) {
    if ( Permission::PermissionCheck($name, Session::get("positionId"), "page") ) {
      if (sizeof($subMenu) == 0) {
        echo '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.$url.'" aria-expanded="false"><i class="mdi '.$icon.'"></i><span class="hide-menu">'.$name.'</span></a></li>';
      } else {
        echo '<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi '.$icon.'"></i><span class="hide-menu">'.$name.' </span></a>';
        echo '<ul aria-expanded="false" class="collapse  first-level">';
          for($i = 0; $i < sizeof($subMenu ); $i++) {
            if ( Permission::PermissionCheck($subMenu[$i][1], Session::get("positionId"), "page") ) {
              echo '<li class="sidebar-item"><a href="' . $subMenu[$i][0] . '" class="sidebar-link"><i class="mdi ' . $subMenu[$i][3] . '"></i><span class="hide-menu"> ' . $subMenu[$i][1] . ' </span></a></li>';
            }
          } 
        echo '</ul>';
        echo '</li>';
      }
    }
  }

  public static function DisplayAlert($msg) {
    if ($msg != "") {
      echo '<div class="alert alert-warning" role="alert" id = "alertDiv">'.$msg.'</div>';
    }
  }

  public static function ConvertToName($name) {
    $name = str_replace('/', '_', $name);
    $name = str_replace('(', '', $name);
    $name = str_replace(')', '', $name);
    $name = str_replace(' ', '', $name);
    $name = str_replace('#', '', $name);
    $name = str_replace('*', '', $name);
    $name = str_replace('-', '', $name);
    $name = str_replace('(Vendor)', 'vendor', $name);
    return strtolower($name);
  }
  
  public static function CreateElement($name = '', $type = '', $options = array(), $value = '', $withoutLabel = false, $hide = false, $permission = '', $addOn = '') {
    switch($type) {
      case "text": self::CreateText($name, $value, $addOn, $permission, $withoutLabel); break;
      case "textarea": self::CreateTextarea($name, $value, false, $permission); break;
      case "dropdown" : self::CreateDropDown($name, $options, $value, $withoutLabel, $hide, $permission, $addOn); break;
      case "hidden": self::CreateHidden($name, $value); break;
      case "file": self::CreateFileSelector($name, $permission); break;
      case "imagePdf": self::CreatePopup($name, $value, $permission); break;
      case "radio": self::CreateRadio($name, $options, $value, $permission); break;
      case "password": self::CreatePassword($name, $value); break;
      case "date": self::CreateDateSelector($name, $value, $permission); break;
      case "thumbnail": self::CreateThumbnail($value); break;
      case "checkbox": self::CreateCheckbox($name, $options, $value, $permission); break;
    }
  }

  public static function CreateCheckbox($name = '',  $options = array(), $value = '', $permission = '') {
    echo '<div class="form-group row">';  
    echo '<label class="col-md-3">'. $name .'</label>';
    echo '<div class="col-md-9">';
    if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {

        foreach($options as $option) {
          echo '<div class="custom-control custom-checkbox">';
          $checked = $option->value == $value ? 'checked' : '';
          echo '<input type="checkbox" class="custom-control-input" id="' . self::ConvertToName($name) . $option->value . '" name="' . self::ConvertToName($name) . '" value = "'.$option->value.'" '.  $checked . '>';
          echo '<label class="custom-control-label" for="' . self::ConvertToName($name) . $option->value . '"> ' . $option->text . ' </label>';
          echo '</div>';
        }
      }
      echo '</div>';
    echo '</div>';
  }

  public static function CreateThumbnail($value) {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3"></label>';
      echo '<div class="col-md-9">';
      echo '<img src="' .Url::getDomain()  . $value . '" class="img-fluid" style = "max-height:60px">';
      echo '</div>';
    echo '</div>';
  }

  public static function CreateDateSelector($name, $value, $permission = '') {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3">' . $name . '</label>';
      echo '<div class="col-md-9">';
       
        if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {

          echo '<div class="input-group">';
          echo '<input type="text" class="form-control"';
          if ($value != '1970-01-01' && $value != '0000-00-00') {
            echo '  value = "' . $value . '" ';
          }
          echo 'name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" class = "datepicker-autoclose" placeholder="yyyy-mm-dd">';
          echo '<div class="input-group-append">';
          echo '<span class="input-group-text"><i class="fa fa-calendar"></i></span>';
          echo '</div>';
          echo '</div>';

        } else {
          echo $value;
        }

      echo '</div>';
      echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
    echo '</div>';
  }


  public static function CreateRadio($name = '', $radioSet = array(), $value = '', $permission = '') {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3">'.$name .'</label>';
        echo '<div class="col-md-9">'; 
        if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {
          foreach($radioSet as $option) {
            echo '<div class="custom-control custom-radio">';
            $checked = $option->value == $value ? 'checked' : '';
            echo '<input type="radio" class="custom-control-input" id="' . self::ConvertToName($name) . $option->value . '" name="' . self::ConvertToName($name) . '" value = "'.$option->value.'" '.  $checked . '>';
            echo '<label class="custom-control-label" for="' . self::ConvertToName($name) . $option->value . '"> ' . $option->text . ' </label>';
            echo '</div>';
          }
        } else {
          foreach($radioSet as $option) {
            if ( $option->value == $value) {
              echo  $option->text;
            }
          }
        }
      echo '</div>';
      echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
    echo '</div>';
  }

  public static function CreateTextarea($name = '', $value = '', $isNumber = false, $permission = '') {
    echo '<div class="form-group row">';
    echo '<label class="col-md-3">' . $name . '</label>';
    echo '<div class="col-md-9">';
    if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {
        echo '<textarea class="form-control" id = "'. self::ConvertToName($name).'"  name = "'. self::ConvertToName($name).'"  placeholder="'.$name.'" aria-label="'.$name.'" rows = "10">';
        echo $value.'</textarea>';
      } else {
        echo $value;
      }

    echo '</div>';
    echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
  echo '</div>';
  }

  public static function CreateText($name = '', $value = '', $isNumber = false, $permission = '', $withoutLabel = false) {
    if ($withoutLabel == false) {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3">' . $name . '</label>';
      echo '<div class="col-md-9">';
    }
        if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {
          echo '<input type="text" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" ';
          if ($isNumber) {
            echo 'onkeypress="return isNumberKey(event)"';
          }
          echo '" class="form-control" placeholder="'.$name.'" aria-label="'.$name.'" value = "' . $value . '">';
        } else {
          echo $value;
        }
    if ($withoutLabel == false) {
      echo '</div>';
      echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
    echo '</div>';
    }
  }

  public static function CreatePassword($name = '', $value = '', $isNumber = false) {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3">' . $name . '</label>';
      echo '<div class="col-md-9">';
        echo '<input type="password" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" ';
        if ($isNumber) {
          echo 'onkeypress="return isNumberKey(event)"';
        }
        echo '" class="form-control" placeholder="'.$name.'" aria-label="'.$name.'" value = "' . $value . '">';
      echo '</div>';
      echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
    echo '</div>';
  }

  public static function CreateDropDown($name = '', $options = array(), $value = '', $withoutLabel = false, $hide = false, $permission = '', $addOn = '') {
    if ($withoutLabel == false) {
      echo '<div class="form-group row" ';
      if ($hide == true) {
        echo 'style = "display:none;"';
      }
      echo '>';
      echo '<label class="col-md-3">'.$name.'</label>';
      echo '<div class="col-md-9">';
    }

      if ( Permission::PermissionCheck($permission, Session::get("positionId"), "func") ) {
        $isShown = false;
        $width = 70;
        if ($options != null) {
          foreach($options as $option) {
            if ($option->value == $value) {
              $isShown = true;
              $width = 100;
            }
          }
        }
        echo '<select name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" class="select2 form-control custom-select" style="width: '.$width.'%; height:36px;" ' . $addOn . '>';
          foreach($options as $option) {
            $selected = $option->value == $value ? 'selected' : '';
            echo '<option value = "' .$option->value . '" ' .  $selected . '>' . $option->text. '</option>';
          }
        echo '</select>';
        if ($isShown == false) {
          echo '&nbsp;' . $value;
        }
      } else {
        // echo $value;
        $isShown = false;
        foreach($options as $option) {
          // echo $option->value. ' ';
          if ($option->value == $value) {
            $isShown = true;
            echo $option->text != "Select" ? $option->text : '';
          }
        }
        if ($isShown == false) {
          echo $value;
        }
      }

    if ($withoutLabel == false) {
        echo '</div>';
        echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
      echo '</div>';
    }
  }

  public static function CreateHidden($name = '', $value = '') {
    echo '<input type = "hidden" name = "'. self::ConvertToName($name) .'" id = "'. self::ConvertToName($name) .'" value = "' . $value . '" />';
  }

  public static function CreateTableHeader($options, $addSearchBox = false, $class = 'searchText') {
    foreach($options as $tableHeader) {
      echo '<th>' . $tableHeader;
      if ($addSearchBox == true) {
        if ($tableHeader != 'Edit' && $tableHeader != 'Detail' && $tableHeader != 'Add Lines') {
          echo '<input type="text" class = "'.$class.'" id = "' .  self::ConvertToName( $tableHeader) .  '" placeholder="Search '.$tableHeader .'" />';
        }
      }
      echo '</th>';
    }
  }

  public static function CreateTableRow($options, $withDelete = false) {
    foreach($options as $tableRow) {
      echo '<tr>';
      if ($withDelete) {
        echo '<form method = "POST">';
        self::CreateElement('action', 'hidden', null, 'delete');
        $id = 0;
        foreach ($tableRow as $cell => $value) {
          if ($cell == 'id') {
            $id = $value;
          }
          if ($cell != 'id') {
            self::CreateElement('id', 'hidden', null, $id);
            echo '<td>' . $value .  '</td>';    
            echo '<td><button class = "btn btn-danger">Delete</button></td>';
          }
        }
        echo "</form>";
      } else {
        foreach ($tableRow as $cell => $value) {
          echo '<td>' . $value .  '</td>';    
        }
      }
      echo '</tr>';
    }
  }

  public static function CreateFileSelector($name) {
    echo '<div class="form-group row">';
      echo '<label class="col-md-3">' . $name . '</label>';
      echo '<div class="col-md-9">';
        echo '<div class="custom-file">';
        echo '<input type="file" class="form-control" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" >';
        // echo '<label class="custom-file-label" for="validatedCustomFile">Choose file...</label>';
        echo '</div>';
      echo '</div>';
      echo '<div class="col-md-9 offset-md-3" id = "'. self::ConvertToName($name) .'Error"></div>';
    echo '</div>';
  }

  public static function CreateButton($name, $permission) {

  }

  public static function CreatePopup($name, $value, $text = '', $isThumbnail = false) {
    self::CreatePopupHyperLink($name, $value, $text, $isThumbnail);
    self::CreatePopupModal($name, $value);
  }

  public static function CreatePopupHyperLink($name, $value, $text = '', $isThumbnail = false, $isHtml = false) {
    if ($isThumbnail == true) {
      if ($isHtml == true) {
        $html = "";
        $html .=  "<a href = \"#\" data-toggle=\"modal\" data-target=\"#" . $name . "\">";
        $html .= "<img src = \"" .URL::getDomain() . $value . "\" class = \"thumb-lg\" >";
        $html .=  "</a>";
        return $html;
      } else {
        echo '<a href = "#" data-toggle="modal" data-target="#' . $name .'">';
        echo '<img src = "'. URL::getDomain() . $value . '" class = "thumb-lg"/>';
        echo '</a>';
      }

    } else {
      echo '<button type="button" class="btn btn-light margin-5" data-toggle="modal" data-target="#' . $name .'">';
      echo $text;
      echo '</button>';
    }
  }

  public static function CreatePopupModal($name, $value) {
    echo '<div class="modal fade" id="'.$name.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<img src="'. Url::getDomain() . $value.'" width="100% ">';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  public static function DebugArray($array) {
    print_r("<pre>" . print_r($array, true) . "</pre>");
  }
}
?>