<?php
// lib/php/themes/bootstrap/vmails.php 20170101 - 20180430
// Copyright (C) 2015-2018 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Bootstrap_Vmails extends Themes_Bootstrap_Theme
{
    public function create(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function update(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function list(array $in) : string
    {
error_log(__METHOD__);

        return '
          <div class="col-12">
            <h3>
              <i class="fas fa-envelope fa-fw"></i> Mailboxes
              <a href="#" title="Add New Mailbox" data-toggle="modal" data-target="#createmodal">
              <!-- <a href="?o=vmails&m=create" title="Add Mailbox"> -->
                <small><i class="fas fa-plus-circle fa-fw"></i></small>
              </a>
            </h3>
          </div>
        </div><!-- END UPPER ROW -->
        <div class="row">
          <div class="table-responsive">
            <table id=vmails class="table table-sm" style="min-width:1100px;table-layout:fixed">
              <thead class="nowrap">
                <tr>
                  <th>Email</th>
                  <th>Domain</th>
                  <th data-sortable="false"></th>
                  <th>Usage&nbsp;</th>
                  <th data-sortable="false"></th>
                  <th>Quota</th>
                  <th class="text-left">Msg&nbsp;#&nbsp;</th>
                  <th data-sortable="false"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

          <div class="modal fade" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="createmodal" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Mailboxes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="post" action="' . $this->g->cfg['self'] . '">
                  <div class="modal-body">
                    <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
                    <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
                    <input type="hidden" name="m" value="create">
                    <div class="form-group">
                      <label for="user" class="form-control-label">Mailbox</label>
                      <input type="text" class="form-control" id="user" name="user">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="spamf" id="spamf" checked>
                        <label class="custom-control-label" for="spamf">Spam Filter</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Mailbox</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <script>
$(document).ready(function() {
  $("#vmails").DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": "?x=json&o=vmails&m=list",
    "columnDefs": [
      {"targets":0, "className":"text-truncate", "width":"25%"},
      {"targets":1, "className":"text-truncate", "width":"20%"},
      {"targets":2, "className":"align-middle"},
      {"targets":3, "className":"text-right", "width":"4rem"},
      {"targets":4, "className":"text-center", "width":"0.5rem"},
      {"targets":5, "width":"4rem"},
      {"targets":6, "className":"text-right", "width":"3rem"},
      {"targets":7, "className":"text-right", "width":"4rem"}
    ]
  });
});
          </script>';
    }

    function editor(array $in) : string
    {
error_log(__METHOD__);

        extract($in);

        $active_checked = ($active ? 1 : 0) ? ' checked' : '';
        $filter_checked = ($spamf ? 1 : 0) ? ' checked' : '';

        $passwd1  = $passwd1 ?? '';
        $passwd2  = $passwd2 ?? '';

        $header   = $this->g->in['m'] === 'create' ? 'Add Mailbox' : 'Update Mailbox';
        $submit   = $this->g->in['m'] === 'create' ? '
                      <a class="btn btn-secondary" href="?o=vmails&m=list">&laquo; Back</a>
                      <button type="submit" name="m" value="create" class="btn btn-primary">Add Mailbox</button>' : '
                      <a class="btn btn-secondary" href="?o=vmails&m=list">&laquo; Back</a>
                      <a class="btn btn-danger" href="?o=vmails&m=delete&i=' . $this->g->in['i'] . '" title="Remove mailbox" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $user . '?\')">Remove</a>
                      <button type="submit" name="m" value="update" class="btn btn-primary">Update</button>';
        $enable   = $this->g->in['m'] === 'create' ? '
                <input type="text" autocorrect="off" autocapitalize="none" class="form-control" name="user" id="user" value="' . $user . '">' : '
                <input type="text" class="form-control" value="' . $user . '" disabled>
                <input type="hidden" name="user" id="user" value="' . $user . '">';

        return '
          <div class="col-12">
            <h3><a href="?o=vmails&m=list">&laquo;</a> ' . $header . '</h3>
          </div>
        </div><!-- END UPPER ROW -->
        <div class="row">
          <div class="col-12">
            <form method="post" action="' . $this->g->cfg['self'] . '">
              <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
              <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
              <div class="row">
                <div class="form-group col-4">
                  <label for="domain">Email Address</label>' . $enable . '
                </div>
                <div class="form-group col-2">
                  <label for="quota">Mailbox Quota</label>
                  <input type="number" class="form-control" name="quota" id="quota" value="' . intval($quota / 1000000) . '">
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="passwd1">Password</label>
                    <input type="password" class="form-control" name="passwd1" id="passwd1" value="' . $passwd1 . '">
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="passwd2">Confirm Password</label>
                    <input type="password" class="form-control" name="passwd2" id="passwd2" value="' . $passwd2 . '">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="spamf" id="spamf"' . $filter_checked . '>
                      <label class="custom-control-label" for="spamf">Spam Filter</label>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="active" id="active"' . $active_checked . '>
                      <label class="custom-control-label" for="active">Active</label>
                    </div>
                  </div>
                </div>
                <div class="col-4 text-right">
                  <div class="btn-group">' . $submit . '
                  </div>
                </div>
              </div>
            </form>
          </div>';
    }
}

?>
