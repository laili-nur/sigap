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
               <p>Akun SIGAP anda telah berhasil dibuat dengan level <span
                     style="font-weight: bold;"><?=$level;?></span>. Silakan login menggunakan data berikut:</p>
               <p style="font-weight: bold;">Username : <?=$username;?></p>
               <p style="font-weight: bold;">Password : <?=$password;?></p>

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