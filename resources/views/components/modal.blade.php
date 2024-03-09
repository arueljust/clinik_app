 <!-- Modal -->
 @push('style')
     <style>
         .modal {
             backdrop-filter: blur(5px);
         }

         .modal-content {
             background-color: rgba(255, 255, 255, 0.5);
         }

         .modal-title {
             font-family: Verdana, Geneva, Tahoma, sans-serif;
         }
     </style>
 @endpush
 <!-- Modal -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalTitle">Modal Title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true" class="custom-close-btn">&times;</span>
                 </button>
             </div>
             <div class="modal-body" id="modalContent">

             </div>
         </div>
     </div>
 </div>
