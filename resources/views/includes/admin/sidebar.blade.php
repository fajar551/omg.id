<div class="iq-sidebar sidebar-default">
   <div id="sidebar-scrollbar">
      <nav class="iq-sidebar-menu">
         <ul id="iq-sidebar-toggle" class="iq-menu">
            <li class="{{ activeRouteName('admin.home') }}">
               <a href="{{ route('admin.home') }}" class=" ">
                  <i class="ri-dashboard-2-line"></i>
                  <span> @lang('page.menu_dashboard') </span>
               </a>
            </li>
            <li class="{{ activeRouteName('admin.master.*') }}">
               <a href="#data-master" data-bs-toggle="collapse" class="  collapsed" aria-expanded="false">
                  <i class="ri-database-2-line"></i>
                  <span> @lang('Data Master') </span>
                  <i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               <ul id="data-master" class="iq-submenu collapse" data-bs-parent="#iq-sidebar-toggle">
                     <li class="{{ activeRouteName('admin.master.paymentmethod.*') }}">
                        <a href="{{ route('admin.master.paymentmethod.index') }}">
                           <i class="ri-secure-payment-line"></i>  @lang('Payment Method') 
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.master.pagecategory.*') }}">
                        <a href="{{ route('admin.master.pagecategory.index') }}">
                           <i class="ri-page-separator"></i> @lang('Page Category')
                        </a>
                     </li>
                     {{-- <li class="{{ activeRouteName('admin.master.contentcategory.*') }}">
                        <a href="{{ route('admin.master.contentcategory.index') }}">
                           <i class="ri-pages-line"></i> @lang('Content Category')
                        </a>
                     </li> --}}
                     <li class="{{ activeRouteName('admin.master.payoutchannel.*') }}">
                        <a href="{{ route('admin.master.payoutchannel.index') }}">
                           <i class="ri-pages-line"></i> @lang('Payout Channel')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.master.defaultitem.*') }}">
                        <a href="{{ route('admin.master.defaultitem.index') }}">
                           <i class="ri-pantone-line"></i> @lang('Default Item')
                        </a>
                     </li>
               </ul> 
            </li>
            <li class="{{ activeRouteName('admin.creator.*') }}">
               <a href="#manage-creator" data-bs-toggle="collapse" class="  collapsed" aria-expanded="false">
                  <i class="ri-shield-user-line"></i>
                  <span> @lang('Manage Creator') </span>
                  <i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               <ul id="manage-creator" class="iq-submenu collapse" data-bs-parent="#iq-sidebar-toggle">
                     <li class="{{ activeRouteName('admin.creator.list.*') }}">
                        <a href="{{ route('admin.creator.list.index') }}">
                           <i class="ri-list-check-2"></i> @lang('Creator List')
                        </a>
                     </li>
                     {{-- <li class="{{ activeRouteName('admin.creator.paymentaccount.*') }}">
                        <a href="{{ route('admin.creator.paymentaccount.index') }}">
                           <i class="ri-secure-payment-fill"></i> @lang('Payment Account')
                        </a>
                     </li> --}}
                     <li class="{{ activeRouteName('admin.creator.payoutaccount.*') }}">
                        <a href="{{ route('admin.creator.payoutaccount.index') }}">
                           <i class="ri-money-dollar-box-line"></i> @lang('Payout Account')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.creator.reportedaccount.*') }}">
                        <a href="{{ route('admin.creator.reportedaccount.index') }}">
                           <i class="ri-alarm-warning-line"></i> @lang('Reported Account')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.creator.reportedcontent.*') }}">
                        <a href="{{ route('admin.creator.reportedcontent.index') }}">
                           <i class="ri-information-line"></i> @lang('Reported Content')
                        </a>
                     </li>
               </ul>
            </li>
            <li class="{{ activeRouteName('admin.transaction.*') }}">
               <a href="#transaction" data-bs-toggle="collapse" class="  collapsed" aria-expanded="false">
                  <i class="ri-currency-line"></i>
                  <span> @lang('Transactions') </span>
                  <i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               <ul id="transaction" class="iq-submenu collapse" data-bs-parent="#iq-sidebar-toggle">
                     <li class="{{ activeRouteName('admin.transaction.support.*') }}">
                        <a href="{{ route('admin.transaction.support.index') }}">
                           <i class="ri-hand-heart-line"></i> @lang('Support')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.transaction.disbursement.*') }}">
                        <a href="{{ route('admin.transaction.disbursement.index') }}">
                           <i class="ri-refund-2-line"></i> @lang('Disbursement')
                        </a>
                     </li>
               </ul>
            </li>
            <li class="{{ activeRouteName('admin.administrator.*') }}">
               <a href="#manage-admin" data-bs-toggle="collapse" class="  collapsed" aria-expanded="false">
                  <i class="ri-admin-line"></i>
                  <span> @lang('Manage Admin') </span>
                  <i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               <ul id="manage-admin" class="iq-submenu collapse " data-bs-parent="#iq-sidebar-toggle">
                     <li class="{{ activeRouteName('admin.administrator.list.*') }}">
                        <a href="{{ route('admin.administrator.list.index') }}">
                           <i class="ri-list-check-2"></i> @lang('Administrator')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.administrator.role.*') }}">
                        <a href="{{ route('admin.administrator.role.index') }}">
                           <i class="ri-folder-user-line"></i> @lang('Role')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.administrator.permission.*') }}">
                        <a href="{{ route('admin.administrator.permission.index') }}">
                           <i class="ri-lock-unlock-line"></i> @lang('Permission')
                        </a>
                     </li>
               </ul>
            </li>
            <li class="{{ activeRouteName('admin.setting.*') }}">
               <a href="#setting" data-bs-toggle="collapse" class="  collapsed" aria-expanded="false">
                  <i class="ri-settings-5-line"></i>
                  <span> @lang('Setting') </span>
                  <i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               <ul id="setting" class="iq-submenu collapse" data-bs-parent="#iq-sidebar-toggle">
                     <li class="{{ activeRouteName('admin.setting.system.*') }}">
                        <a href="{{ route('admin.setting.system.index') }}"><i class="ri-equalizer-line"></i>
                           @lang('System')</a>
                     </li>
                     <li class="{{ activeRouteName('admin.setting.profile.*') }}{{ activeRouteName('admin.setting.changepw.*') }}">
                        <a href="{{ route('admin.setting.profile.index') }}">
                           <i class="ri-user-settings-line"></i> @lang('Account')
                        </a>
                     </li>
                     <li class="{{ activeRouteName('admin.setting.feature.*') }}">
                        <a href="{{ route('admin.setting.feature.index') }}">
                           <i class="ri-service-line"></i> @lang('Feature')
                        </a>
                     </li>
               </ul>
            </li>
         </ul>
      </nav>
      <div class="p-5"></div>
   </div>
</div>