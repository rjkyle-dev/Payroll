<?php
$title = "Employees";
require_once views_path("partials/header");
// require_once views_path("partials/sidebar");
// require_once views_path("partials/nav");
?>

    <button type="button" class="btn btn-primary float-end mt-1 mb-1" data-bs-toggle="modal" data-bs-target="#addProducts">
    Add New
    </button> 

<div class="modal fade" id="addProducts" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <i class="bi bi-person-plus text-[#16a249] fs-4 mr-2"></i>
        <h1 class="modal-title fs-5 text-[#16a249]" id="addModalLabel">Add Employees</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid  p-2 ">
          <form method="post" action="index.php?payroll=employees" enctype="multipart/form-data">
          <div class="border rounded-lg mb-4">
                <div class="bg-yellow-100 px-4 py-2 rounded-t-lg border-b">
                    <span class="font-semibold text-[#133913]">PERSONAL INFORMATION</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-start">


                    <!-- Photo Upload -->
                    <div class="flex flex-col items-center md:col-span-1">
                        <div class="relative w-32 h-32 mb-2 mt-1 flex items-center justify-center bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#16a249] transition-all duration-200">
                            <input type="file" id="employeePhoto" name="photo_path" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewEmployeePhoto(event); displayFileName(this); validateInput(this);">
                            <img id="employeePhotoPreview" alt="Employee Photo" class="w-full h-full object-cover rounded-lg absolute top-0 left-0 z-0" style="display:none;">
                            <span id="photoPlaceholder" class="flex flex-col items-center justify-center text-gray-400 z-0">
                                <i class="bi bi-image text-3xl mb-1"></i>
                                <span class="text-xs">Upload Photo</span>
                            </span>
                        </div>
                        <span id="photoFileName" class="text-sm text-gray-600 mt-1 text-center break-all max-w-[128px]"></span>
                        <div class="validation-message text-red-500 text-xs mt-1"></div>
                        
                        <script>
                        function previewEmployeePhoto(event) {
                            const input = event.target;
                            const preview = document.getElementById('employeePhotoPreview');
                            const placeholder = document.getElementById('photoPlaceholder');
                            
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                    placeholder.style.display = 'none';
                                }
                                
                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        function displayFileName(input) {
                            const fileNameSpan = document.getElementById('photoFileName');
                            if (input.files && input.files[0]) {
                                fileNameSpan.textContent = input.files[0].name;
                            } else {
                                fileNameSpan.textContent = '';
                            }
                        }
                        </script>
                    </div>
                    <!-- Input Fields Grid -->


                    <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 w-full">
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">EMPLOYEE ID</label>
                            <div class="relative">
                                <input type="text" name="employeeNo" placeholder="EMPLOYEE ID" class="p-2 pl-8 border rounded 
                                text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 md:col-span-2 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">RFID NUMBER</label>
                            <div class="relative">
                                <input type="text" name="rfidNumber" placeholder="RFID NUMBER" class="p-2 pl-8 border rounded 
                                text-sm w-full focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">FIRST NAME</label>
                            <div class="relative">
                                <input type="text" name="firstName" placeholder="FIRST NAME" class="p-2 pl-8 border rounded 
                                text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">MIDDLE NAME</label>
                            <div class="relative">
                                <input type="text" name="middleName" placeholder="MIDDLE NAME" class="p-2 pl-8 border rounded 
                                text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">LAST NAME</label>
                            <div class="relative">
                                <input type="text" name="lastName" placeholder="LAST NAME" class="p-2 pl-8 border rounded 
                                text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div class="md:col-span-4 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 w-full">
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">BIRTHDAY</label>
                            <div class="relative">
                                <input type="date" name="dob" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">PLACE OF BIRTH</label>
                            <div class="relative">
                                <input type="text" name="placeOfBirth" placeholder="PLACE OF BIRTH" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">SEX</label>
                            <div class="relative">
                                <select name="sex" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">CIVIL STATUS</label>
                            <div class="relative">
                                <select name="civilStatus" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                    <option value="">Select</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">CONTACT NUMBER</label>
                            <div class="relative">
                                <input type="text" name="contactNumber" placeholder="CONTACT NUMBER" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">EMAIL</label>
                            <div class="relative">
                                <input type="email" name="email" placeholder="EMAIL" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">CITIZENSHIP</label>
                            <div class="relative">
                                <input type="text" name="citizenship" placeholder="CITIZENSHIP" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">BLOOD TYPE</label>
                            <div class="relative">
                                <select name="bloodType" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">POSITION</label>
                            <div class="relative">
                                <select name="position" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                    <option value="">Select Position</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Officer">Officer</option>
                                    <option value="Specialist">Specialist</option>
                                    <option value="Assistant">Assistant</option>
                                    <option value="Coordinator">Coordinator</option>
                                    <option value="Analyst">Analyst</option>
                                </select>
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="col-span-3 flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">COMPLETE ADDRESS</label>
                            <div class="relative">
                                <input type="text" name="address" placeholder="COMPLETE ADDRESS" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                </div>

                <div class="border-t">
                    <div class="bg-yellow-100 px-4 py-2 border-b">
                        <span class="font-semibold text-[#133913]">SALARY INFORMATION</span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">BASE SALARY</label>
                            <div class="relative">
                                <input type="text" name="baseSalary" placeholder="BASE SALARY" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">SSS NUMBER</label>
                            <div class="relative">
                                <input type="text" name="sssNumber" placeholder="SSS NUMBER" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">PAG-IBIG NUMBER</label>
                            <div class="relative">
                                <input type="text" name="pagibigNumber" placeholder="PAG-IBIG NUMBER" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">PHILHEALTH NUMBER</label>
                            <div class="relative">
                                <input type="text" name="philhealthNumber" placeholder="PHILHEALTH NUMBER" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                        <div class="flex flex-col gap-1 relative">
                            <label class="block text-xs font-medium mb-1 ml-2">GSIS NUMBER</label>
                            <div class="relative">
                                <input type="text" name="gsisNumber" placeholder="GSIS NUMBER" class="p-2 pl-8 border rounded text-sm focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249] w-full" required onchange="validateInput(this)">
                                <i class="validation-icon absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                            </div>
                            <div class="validation-message text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="border-top: none;">
              <button type="submit" class="px-6 py-2 bg-[#16a249] text-white rounded hover:bg-[#12813a] transition-colors duration-200 font-semibold">Add Employee</button>
              <button type="button" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors duration-200 font-semibold" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>


            <!-- Category -->
            <!-- <div class="mb-3">
              <label for="categorySelect" class="form-label">Category</label>
              <select name="category" class="form-control">
                <option value="" disabled selected>Select Category</option>
                <option value="Coffee">Coffee</option>
                <option value="Ice Cream">Ice Cream</option>
                <option value="Milk Tea">Milk Tea</option>
                <option value="Snacks">Snacks</option>
              </select>

            </div> -->
            
            <!-- Product Name -->
            <!-- <div class="mb-3">
              <label for="productName" class="form-label">Product Name</label>
              <input type="text" name="name" class="form-control" id="productName" placeholder="Enter product name" required>
            </div> -->

            <!-- Amount -->
            <!-- <div class="input-group mb-3">
              <span class="input-group-text">Amount:</span>
              <input name="price" type="number" class="form-control" aria-label="Amount" step="1.00" min="1" placeholder="Enter amount">

            </div> -->

            <!-- Product Image -->
            <!-- <div class="mb-3">
              <label for="productImage" class="form-label">Product Image</label>
              <input type="file" name="image" class="form-control" id="productImage">
            </div> -->
        </div>
      </div>

      <!-- <div class="modal-footer" style="border-top: none;">
              <button type="submit" class="px-6 py-2 bg-[#16a249] text-white rounded hover:bg-[#12813a] transition-colors duration-200 font-semibold">Add Employee</button>
              <button type="button" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors duration-200 font-semibold" data-bs-dismiss="modal">Cancel</button>
            </div> -->
          </form>
    </div>
  </div>
</div>

<?php require_once views_path("partials/footer"); ?>
