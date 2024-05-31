<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class DashboardFile {

    Public Static Function photo($tablename,$parent)
    {
      echo '<br />';
      echo '<div class="row">';
      $query = DB::fetch("SELECT * FROM sta_sections_website_photo WHERE tablename=? AND parent=? ORDER BY ord", array($tablename,$parent));
      foreach ($query as $row) {
        echo '
          <div class="col-xs-6 col-sm-4 col-md-3" id="photo-delete-area">
            <div class="panel" style="padding:5px 8px;">
              <div class="row">
                <div class="col-md-6 col-xs-6 pb-1">
                  <input type="number" id="'.$row->id.'" value="'.($row->ord==100 ? 0 : $row->ord).'" class="photo-ord-update" style=" width: 50px; height: 22px;" />
                </div>
                <div class="col-md-6 col-xs-6 pb-1 text-right">
                  <button id="'.$row->id.'" type="button" class="btn btn-danger btn-sm photo-delete-link" style="padding:0 8px;"><i class="fa fa-trash"></i></button>
                </div>
                <div class="col-md-12 col-xs-12 pb-1">
                  <img src="'.PATH_UPLOAD.'/Photos/'.$row->folder.'/medium/'.$row->name.'">
                </div>
              </div>
            </div>
          </div>
        ';
      }
      echo '</div>';
    }

    Public Static Function slider($area)
    {
      echo '<br />';
      echo '<div class="row">';
      $query = DB::fetch("SELECT * FROM sta_data_slider_list WHERE area=? ORDER BY ord ASC", array($area));
      foreach ($query as $row) {
        echo '
          <div class="col-md-12" id="slider-delete-area">
            <div class="panel" style="padding:5px 8px;">
              <div class="row">
                <div class="col-md-1 col-xs-6 pb-1">
                  <input type="number" id="'.$row->id.'" value="'.($row->ord==100 ? 0 : $row->ord).'" class="slider-ord-update" style=" width: 100%; height: 22px;" />
                </div>
                <div class="col-md-10 col-xs-6 pb-1">
                  <input type="text" id="'.$row->id.'" value="'.$row->content.'" class="slider-content-update" style=" width: 100%; height: 22px;" />
                </div>
                <div class="col-md-1 col-xs-6 pb-1">
                  <button id="'.$row->id.'" type="button" class="btn btn-danger btn-sm slider-delete-link" style="padding:0 8px;"><i class="fa fa-trash"></i></button>
                </div>
                <div class="col-md-12 col-xs-12 pb-1">
                  <img src="'.PATH_UPLOAD.'/Sliders/'.$row->name.'">
                </div>
              </div>
            </div>
          </div>
        ';
      }
      echo '</div>';
    }

  }
