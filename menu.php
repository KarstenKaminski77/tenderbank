<td width="245" align="right" valign="top">
                <?php if(isset($_SESSION['userid']) && $_SESSION['userlevel'] < 10){ ?>
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="245" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_01_2.jpg'; ?>" width="245" height="67" /></td>
                  </tr>
                  <tr>
                    <td width="245" valign="top"><div id="login-panel" style="background-image:url(<?php echo $_SERVER['HOST'].'/images/right_02.jpg'; ?>)">
                      <table width="100%" border="0" cellspacing="3" cellpadding="2">
                        <tr>
                          <td align="right"><b>Lsat Seen</b><br /><?php last_logout(); ?></td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/edit-details.php' ?>">Company Details</a><br /></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/rft.php'; ?>">Request For  Tender</a></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td align="right"><a href="active-tenders.php">View Active Tenders</a></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right"><a href="<?php echo $_SERVER['new/HOST'].'/logout.php'; ?>"><img src="<?php echo $_SERVER['new/HOST'].'/images/btn-logout.jpg'; ?>" width="65" height="30" border="0" /></a></td>
                        </tr>
                      </table>
                    </div></td>
                  </tr>
                  <tr>
                    <td width="245" align="right" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_03.jpg'; ?>" width="245" height="18" /></td>
                  </tr>
                  </table>
                  <?php } elseif(isset($_SESSION['userid']) && $_SESSION['userlevel'] == 10){ ?>
<table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="245" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_01_2.jpg'; ?>" width="245" height="67" /></td>
                  </tr>
                  <tr>
                    <td width="245" valign="top"><div id="login-panel" style="background-image:url(<?php echo $_SERVER['HOST'].'/images/right_02.jpg'; ?>)">
                      <table width="100%" border="0" cellspacing="3" cellpadding="2">
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/admin/about.php'; ?>">About Us</a><br /></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/admin/nature-business.php'; ?>">Nature of Business</a></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/admin/registered-users.php'; ?>">Registered Users</a></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td align="right"><a href="<?php echo $_SERVER['new/HOST'] .'/admin/terms.php'; ?>">Terms</a></td>
                          <td align="right"><img src="<?php echo $_SERVER['new/HOST'].'/images/bullet.png'; ?>" width="7" height="7" /></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right"><a href="<?php echo $_SERVER['new/HOST'].'/logout.php'; ?>"><img src="<?php echo $_SERVER['new/HOST'].'/images/btn-logout.jpg'; ?>" width="65" height="30" border="0" /></a></td>
                        </tr>
                      </table>
                    </div></td>
                  </tr>
                  <tr>
                    <td width="245" align="right" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_03.jpg'; ?>" width="245" height="18" /></td>
                  </tr>
                  </table>                  
				  <?php } else { ?>
<table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="245" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_01.jpg'; ?>" width="245" height="67" /></td>
                  </tr>
                  <tr>
                    <td width="245" valign="top"><div id="login-panel" style="background-image:url(<?php echo $_SERVER['HOST'].'/images/right_02.jpg'; ?>)">
                      <form id="form1" name="form1" method="post" action="">
                      <input name="username" type="text" class="tarea" id="username" value="Username" onclick="clickclear(this, 'Username')" onblur="clickrecall(this,'Username')" />
                        <?php validate_username(); ?>
                        <br />
                       <input name="password" type="text" class="tarea" id="password" value="Password" onclick="clickclear(this, 'Password')" onblur="clickrecall(this,'Password')" />
                       <?php validate_password(); ?>
                       <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><br />      <input name="button" type="submit" class="btn-login" style="background-image:url(<?php echo $_SERVER['HOST'].'/images/btn-login.jpg)'; ?>" id="button" value="" /></td>
      </tr>
  </table>
                      </form>
                      
                    </div></td>
                  </tr>
                  <tr>
                    <td width="245" align="right" valign="top"><img src="<?php echo $_SERVER['new/HOST'].'/images/right_03.jpg'; ?>" width="245" height="18" /></td>
                  </tr>
                  </table>				  <?php } ?>
                  </td>