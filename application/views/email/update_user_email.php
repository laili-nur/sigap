<tr>
   <td class="wrapper">
      <h1 style="margin-bottom: 0;padding-bottom:0;font-weight: bold;">SIGAP</h1>
      <h3 style="text-align: center;">Sistem Informasi Gama Press</h3>
      <hr>
      <table
         role="presentation"
         cellpadding="0"
         cellspacing="0"
      >
         <tr>
            <td>
               <p>Halo <?=$username;?>,</p>
               <p>Akun SIGAP anda telah diperbarui. Berikut data baru akun anda:</p>
               <p style="font-weight: bold;">Username : <?=$username;?></p>
               <?php if ($password): ?>
               <p style="font-weight: bold;">Password : <?=$password;?></p>
               <?php endif;?>
               <p style="font-weight: bold;">Level : <?=$level;?></p>
               <p style="font-weight: bold;color:<?=$status == "Aktif" ? 'green' : 'red';?>">Status : <?=$status;?>
               </p>
               <br>
               <table
                  role="presentation"
                  cellpadding="0"
                  cellspacing="0"
                  class="btn btn-primary"
               >
                  <tbody>
                     <tr>
                        <td>
                           <table
                              role="presentation"
                              cellpadding="0"
                              cellspacing="0"
                           >
                              <tbody>
                                 <tr>
                                    <td> <a
                                          href="<?=base_url('login');?>"
                                          target="_blank"
                                       >Login</a> </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </table>
   </td>
</tr>