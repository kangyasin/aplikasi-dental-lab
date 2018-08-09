			
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Group</h4>
            </div>
            	<form id="frm2" action="<?php echo site_url(); ?>admin/group/edit_process_group/<?php echo $menuid.'/'.$ID;?>" method="post" class="contact">
                <div class="modal-body">     
                
                	<script type="text/javascript">
						checked=false;
						function checkedAll (frm2) {var aa= document.getElementById('frm2'); if (checked == false)
						{
							checked = true
						}else
						{
							checked = false
						}
							for (var i =0; i < aa.elements.length; i++)
							{ 
								aa.elements[i].checked = checked;
							}
						}
					</script>
					
						
			
                        <label>Nama Group</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $data_edit[0]->name_group;?>" />
                        
                        <br />
                        
                        <table class="table table-bordered table-striped">

                            <thead>
								<tr>
                                    <th>MENU</th>
                                    <th>
                                        <input type='checkbox' name='checkall' onclick='checkedAll(frm2);'>
                                        Ceklist Semua Akses
                                    </th>
								</tr>
                            </thead>

                              

                              <?php
								  for($a=0 ; $a<count($data_edit) ; $a++)
								  { 
								  	$id_menu=$data_edit[$a]->id_menu;
							  ?>

                                <tr>

                                    <td align="left">
                                        <strong><?=$data_edit[$a]->name_menu;?></strong>
                                    </td>
                                    <td>
										<?
                                            $checked = '';
                                            if($data_edit[$a]->read_flg == 1)
                                            {
                                                $checked = 'checked';
                                            }
                                        ?>
                                        <input type="checkbox" name="read_flg[]" value="<?php echo $data_edit[$a]->id_menu;?>" <?php echo $checked;?>>
                                    </td>
                                </tr>

                                <?php
									$data_child_detail = $this->master_model->edit_child_detail($data_edit[$a]->id_menu, $ID);
									for($b=0; $b < count($data_child_detail); $b++)
									{
										$id_child=$data_child_detail[$b]->ID;
										$name_child=$data_child_detail[$b]->name;
										$id_menu_child=$data_child_detail[$b]->id_menu;
								?>
									<tr>
										<td>
                                            <div style="margin-left:20px;">
												<?php echo $name_child?>
                                            </div>
										</td>
										<td>
											<?
                                                $checked = '';
                                                if($data_child_detail[$b]->read_flg == 1)
                                                {
                                                    $checked = 'checked';
                                                }
                                            ?>
                                            <input type="checkbox" name="read_flg[]" value="<?php echo $id_menu_child?>" <?php echo $checked;?>>
                                        </td>
									  </tr>

									<?

									} //b

								} // a

							?>

                        </table>
					
           </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan">
                <button type="button" class="btn btn-default pull-right" style="margin-right:5px;" data-dismiss="modal">Batal</button>
            </div>
            
            </form>