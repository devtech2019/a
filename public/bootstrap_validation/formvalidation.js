$(document).ready(function() {
//-------------------------------------------------------------------------------------------------------------------------------
var template = $('#line_1').clone();




$('#applyfranchise').bootstrapValidator({
    fields: {
        name: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter Your Name.'
                },
                stringLength:{
                    min:3,
                    max:55,
                    message:' Name Should be between 3 to 55 characters'
                }                                            
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Your Email.'
                },
                // regexp: {
                //     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                //     message: 'This is not a Valid Email Address'
                // }                
            },
        },
        contact_no: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Your Contact No.'
                },                
                stringLength: {
                    min: 10,                  
                    max: 10,
                    message: 'The mobile number should contain 10 digit'
                }, 
                integer : { 
                    message : 'Please Enter Valid Number.',                    
                },                
            },
        },
         company_name: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter Company Name.'
                },
                stringLength:{
                    min:3,
                    max:55,
                    message:'Company Name Should be between 3 to 55 characters'
                }                                            
            }
        },
         address: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Your Address.'
                },
                stringLength:{
                    min:2,
                    max:100,
                    message:'Address not greater then the 100 characters long.'
                }
            },
        },
       city: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter City.'
                },
                stringLength:{
                    min:3,
                    max:55,
                    message:'City Should be between 3 to 55 characters'
                }                                            
            }
        },
        state: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter State.'
                },
                stringLength:{
                    min:3,
                    max:55,
                    message:'State Should be between 3 to 55 characters'
                }                                            
            }
        },
         pincode: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter Pincode.'
                },
                stringLength: {
                required: true,
                min: 6,
                max: 6,
                message:'Pincode Should be 6 numbers'
            },  
            integer : { 
                message : 'Please Enter Valid  Integer Pin Code.',                    
            },                                         
            }
        },
         
    }
});

$('#contact_us').bootstrapValidator({
    fields: {
         name: {
            validators: { 
                notEmpty: {
                    message: 'Please Enter Name.'
                },
                stringLength:{
                    min:3,
                    max:55,
                    message:' Name Should be between 3 to 55 characters'
                }                                            
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Email'
                },
                regexp: {
                    regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                    message: 'This not a valid email address'
                }                
            },
        },
        subject: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Subject'
                },                
                stringLength: {
                    min:3,
                    max:55,
                    message:'Name Should be between 3 to 55 characters'
                }, 
                               
            },
        },
        message: {
            validators: {
                notEmpty: {
                    message: 'Please Enter Message'
                }, 
                stringLength: {
                    min: 3,                  
                    max: 255,
                    message: 'The message should contain 3 to 255 characters'
                },                
            },                            
             
        },
      
    }
});



// $('#newsletter').bootstrapValidator({
//     fields: {
//          name: {
//             validators: { 
//                 notEmpty: {
//                     message: 'Please enter fault name'
//                 },
//                 stringLength:{
//                     min:3,
//                     max:55,
//                     message:'fault name should be between 3 to 55 characters'
//                 }                                            
//             }
//         },
//         user_email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter email!'
//                 },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'This is not a valid email address'
//                 }                
//             },
//         },
        
//     }
// });
// $('#news').bootstrapValidator({
//     fields: {
        
//         user_email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter email!'
//                 },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'This is not a valid email address'
//                 }                
//             },
//         },
        
//     }
// });

// $('.searchModel').bootstrapValidator({
//     fields: {        
//         make_parent: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select brand name'
//                 },               
//             },
//         },
//        type: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select device type'
//                 }               
//             },
//         },
//         modal_child: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select model name'
//                 }
//             },
//         },
//         'faults[]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select fault name'
//                 },                              
//             },
//         },        
//         color: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select color'
//                 },                             
//             },
//         },        
//         postcode: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter postcode'
//                 },
                 
//             }
//         },     
//     }
// });

// $('#search_form').on("click", function(){
//    var bootstrapValidator = $("#searchModel").data('bootstrapValidator');
//    bootstrapValidator.validate();
//     if(bootstrapValidator.isValid()){ 
//         let url = $('meta[name="base_url"]').attr('content');
//         let make_parent = $('#make_id').val();        
//         let postcode = $('#postcode').val(); 
//         $.ajax({
//             type:'POST',
//             url:url+'/search-location/'+make_parent,
//             data:'&postcode='+postcode,
//             dataType: 'json',
//             headers:{
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },      
//             success:function(response){                
//                 if(response.status == 'success'){
//                     if(jQuery.inArray('3', response.data) == -1){ // disabled the pick and drop service
//                         $('.pickupdrop_service').addClass('disabled-box');
//                     }                  
//                     $('#storesteps').modal('show');
//                 }
//                 else{
//                     swal({
//                       title: response.msg,
//                       text: "Click on ok button to close!",
//                       icon: "error",
//                     });
//                 }
//             }
//         });    
//     }
// });


// $('#cart,#checkout-cart').bootstrapValidator({
//     fields: { 
//         customer_fname: {
//             validators: { 
//                 notEmpty: {
//                     message: 'Please Your name'
//                 },
//                 stringLength:{
//                     min:3,
//                     max:55,
//                     message:'Name should be 3 to 55 characters'
//                 }                                            
//             }
//         },
//         customer_email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter email!'
//                 },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'This is not a valid email address'
//                 }                
//             },
//         },
//         customer_phone: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter phone number'
//                 },                
//                 stringLength: {
//                     min: 7,                  
//                     max: 15,
//                     message: 'The mobile number should contain 7 to 15 digit'
//                 }, 
//                 integer : { 
//                     message : 'Please enter the valid number ',                    
//                 },                
//             },
//         },       
//         'billingaddress[line_1]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your street name'
//                 },
//                 stringLength:{
//                     min:2,
//                     max:100,
//                     message:'Street address not greater then the 100 characters long.'
//                 }
//             },
//         },
//         'billingaddress[line_2]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter province name '
//                 }               
//             },
//         },
//         'billingaddress[city]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your city name'
//                 },                
//             },
//         },
//         'billingaddress[postcode]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter postcode'
//                 },
//                 stringLength:{
//                     min:5,
//                     max:15,
//                     message:'Please enter correct length postcode.'
//                 },               
//             },
//         },
//         terms: {
//             validators: {                       
//                 notEmpty: {
//                     message: 'Please check the terms and conidition.'
//                 }                       
//             }
//         }        
//     }
// });



// $('#product_form').bootstrapValidator({
//     fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter brand name'
//                 },
//                 stringLength:{
//                     min:2,
//                     max:55,
//                     message:'Order name should be between 3 to 55 characters'
//                 }
//             },
//         },
//         device_type: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter value of device type'
//                 }               
//             },
//         },
//         model_name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter model name'
//                 },
//                 stringLength:{
//                     min:3,
//                     max:55,
//                     message:'Model name should be between 3 to 55 characters'
//                 },               
//             },
//         },
//         color: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter color name'
//                 },
//                 stringLength:{
//                     min:3,
//                     max:55,
//                     message:'Color name should be between 3 to 55 characters'
//                 },               
//             },
//         },        
//         price: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter price'
//                 },
//                 stringLength:{
//                     min:1,
//                     max:15,
//                     message:'Price should be between 1 to 15 digit'
//                 }             
//             },
//         },        
//         'fault_type[]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select your fault type'
//                 },
                 
//             }
//         },      
//     }
// });

// $('#send_email_reset_password').bootstrapValidator({
//      fields: {
//         email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },
//                 // emailAddress: {
//                 //     message: 'Please enter a valid E-mail'
//                 // }
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         }
//     }
// });

// $('#resetPassword').bootstrapValidator({
//             // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            
//         fields: {
//             password: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please enter your password'
//                     },                        
//                     regexp: {
//                         regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
//                         message: 'Your password must be more than 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
//                     }                                               
//                 }
//             },
//             password_confirmation: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please enter password confirmation'
//                     },
//                     identical: {
//                         field: 'password',
//                         message: 'The password and its confirm are not the same'
//                     }
//                 }
//             }
//         }
//     });


// /*signup front */

//     $('#registeration_form').bootstrapValidator({
//     fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your name'
//                 },
//                 stringLength: {
//                     min: 3,
//                     max: 55,
//                     message: 'The nmae should between 3 to 55 characters long'
//                 },
                
//             },
//         }, 
//         email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },
//                 // remote: {
//                 //     message: 'The email is already in use',
//                 //     url: 'remote_validate',
//                 //     data: {
//                 //         type: 'email'
//                 //     }
//                 // },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         },
//         cellphone: {
//             validators: {
//                  notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//                 integer : { 
//                     message : 'Please enter the valid number ',                    
//                     noSpace:true
//                 },
//                 // remote: {
//                 //     message: 'The cellphone is already in use',
//                 //     url: 'remote_validate',
//                 //     data: {
//                 //         type: 'cellphone'
//                 //     }
//                 // },
//                 stringLength: {
//                     min: 7,
//                     max: 15,
//                     message: 'The number should contain 7 to 15 digit'
//                 },
//             },
//         },
               
//         password: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your password'
//                 },
//                 /*stringLength: {
//                 min: 6,
//                 max: 16,
//                 message: 'The password should contain 6 to 16 characters'
//                 },*/
//                 regexp: {
//                     regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
//                     message: 'Your password must be more than 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
//                 } 
//             }
//         },
//         password_confirmation: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter password confirmation'
//                 },
//                 identical: {
//                     field: 'password',
//                     message: 'The password and its confirm are not the same'
//                 }
//             }
//         },           
//     }   
// });
// // services form validation
// $('#servicereg').bootstrapValidator({
//      fields: {
//         company_name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter company name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The company name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         reg_no: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter registration number'
//                 },             
//                 integer : {
//                     message : 'Please enter valid number'                    
//                 },
                                
//             },            
//         },
//         company_size: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter company size'
//                 },             
                
//             },            
//         },

       
//         employee: {
//                     validators: {
//                         notEmpty: {
//                             message: 'Please enter employee number'
//                         },             
//                         integer : {
//                             message : 'Please enter valid number'                    
//                         },          
//                     },            
//                 },
//         devices: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please enter devices number'
//                     },             
//                     integer : {
//                         message : 'Please enter valid number'                    
//                     },          
//                 },            
//             },        
//         address1: {
//                     validators: {
//                         notEmpty: {
//                             message: 'Please enter address'
//                         }, 
//                         stringLength: {
//                             min: 3,                  
//                             max: 55,
//                             message: 'The address should contain 3 to 55 characters'
//                         },                
//                     },                            
                     
//                 },
      
//         address2: {
//                     validators: {
//                         notEmpty: {
//                             message: 'Please enter address'
//                         }, 
//                         stringLength: {
//                             min: 3,                  
//                             max: 55,
//                             message: 'The address should contain 3 to 55 characters'
//                         },                
//                     },                            
                     
//                 },
//          town: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter Town/City'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The Town/City should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//         post: {
//                     validators: {
//                          notEmpty: {
//                             message: 'Please enter postcode'
//                         },
//                         stringLength: {
//                             min: 3,
//                             max: 10,
//                             message: 'Postal code length between 3 to 10'
//                         }
//                     }
//                 },
//         telephone: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//             regexp: {
//                         regexp: /^([+-]?[0-9]\d*|0)$/,
//                         matches: "[0-9]+",
//                         message: 'The telephone number can only consist of numeric'
//                     },
//                 stringLength: {
//                     min: 7,                  
//                     max: 15,
                   
//                     message: 'The telephone number should contain 7 to 15 digit'
//                 }, 
               
//             },
//         },   
//         registration_type: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter registration type'
//                 },             
                
//             },            
//         },  
//         book_name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter authorized contact name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The Authorized name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         }, 
//         book_phone: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//             regexp: {
//                         regexp: /^([+-]?[0-9]\d*|0)$/,
//                         matches: "[0-9]+",
//                         message: 'The telephone number can only consist of numeric'
//                     },
//                 stringLength: {
//                     min: 7,                  
//                     max: 15,
                   
//                     message: 'The telephone number should contain 7 to 15 digit'
//                 }, 
               
//             },
//         },  
//         book_email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         },
//         bill_name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter authorized contact name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The Authorized name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         }, 
//         bill_phone: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//             regexp: {
//                         regexp: /^([+-]?[0-9]\d*|0)$/,
//                         matches: "[0-9]+",
//                         message: 'The telephone number can only consist of numeric'
//                     },
//                 stringLength: {
//                     min: 7,                  
//                     max: 15,
                   
//                     message: 'The telephone number should contain 7 to 15 digit'
//                 }, 
               
//             },
//         },  
//           bill_email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         },
        
//     },
// });















// $('#coupon_form').bootstrapValidator({
//     fields: {
        
//         price: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter price'
//                 },                
//                 stringLength: {
//                     min: 1,                  
//                     max: 4,
//                     message: 'The price should contain 2 to 4 digit'
//                 }, 
//                 integer : { 
//                     message : 'Please enter the valid price ',                    
//                 },                
//             },
//         },
//         voucher: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter voucher'
//                 }, 
//                 regexp: {
//                     regexp: '[A-Z ]',
//                     message: 'The value must be an uppercase'
//                 }

//             },                            
             
//         },
//         type: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter type'
//                 }, 
//             },
//         },
        
        
       
//     },
// });


// $('#blog_form').bootstrapValidator({
//     fields: {
//         name: {
//             validators: { 
//                 notEmpty: {                    
//                     message: 'The value is not a valid name'
//                 },
//                 stringLength:{
//                     min:3,
//                     max:55,
//                     message:'name should be between 3 to 55 characters'
                    
//                 }                                            
//             }
//         },               
//          content: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter content'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The content should contain 3 to 55 characters'
//                 }               
//             }                            
             
//         },
      
//     }
// });


// $('#editdetails').bootstrapValidator({       
//     fields: {
//             name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your name',
//                 },
//                 stringLength: {
//                     min: 3,
//                     max: 55,
//                     message: 'The name should between 3 to 55 characters long'
//                 }
//             }
//             },  email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },
                
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         },
//            cellphone: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//             regexp: {
//                         regexp: /^([+-]?[0-9]\d*|0)$/,
//                         matches: "[0-9]+",
//                         message: 'The telephone number can only consist of numeric'
//                     },
//                 stringLength: {
//                     min: 7,                  
//                     max: 15,
                   
//                     message: 'The telephone number should contain 7 to 15 digit'
//                 }, 
               
//             },
//         },    
//         }
//     });

// $('#editdetails').bootstrapValidator({
//             // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            
//         fields: {
//             name: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please enter your password'
//                     },                        
//                     // regexp: {
//                     //     regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
//                     //     message: 'Your password must be more than 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
//                     // }                                               
//                 }
//             },
//         }
//     });





// $('#resetpass').bootstrapValidator({
//     fields: {
//             oldpassword: {
//                     validators: {
//                          notEmpty: {
//                             message: 'Please enter your old password'
//                         },
                        

//                     }
//                 },
//                 newpassword: {
//                     validators: {
//                         notEmpty: {
//                             message: 'Please enter your new password'
//                         },
//                         // identical: {
//                         //     field: 'confirmnewpassword',
//                         //     message: 'The password and its confirm are not the same. '
//                         // },
//                         stringLength: {
//                             min: 7,
//                             max: 15,                            
//                             message: 'The password should contain 7 to 15 characters'
//                         },
//                         stringLength: {
//                             min: 4,
//                             max: 15,
//                             message: 'The password should contain 4 to 15 characters'
//                         }  
//                     }
//                 },
//                 confirmnewpassword: {
//                     validators: {
//                         notEmpty: {
//                             message: 'Please enter confirm password.'
//                         },
//                         identical: {
//                             field: 'newpassword',
//                             message: 'The password and its confirm are not the same'
//                         },
//                         stringLength: {
//                             min: 4,
//                             max: 15,
//                             message: 'The password should contain 4 to 15 characters'
//                         }                   
//                     }
//                 }
//         }
// });


// //admin validations start    
 
// $('#admincreate').bootstrapValidator({
//     fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your name'
//                 },
//                 stringLength: {
//                     min: 3,
//                     max: 55,
//                     message: 'The name should between 3 to 55 characters long'
//                 },
                
//             },
//         },
//         'roles[]': {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select role'
//                 },                
//             },
//         }, 
//         email: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your E-mail'
//                 },               
//                 regexp: {
//                     regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                     message: 'The value is not a valid email address'
//                 }
//             },
//         },
//         cellphone: {
//             validators: {
//                  notEmpty: {
//                     message: 'Please supply your contact'
//                 },
//                 integer : { 
//                     message : 'Please enter the valid number ',                    
//                     noSpace:true
//                 },
                
//                 stringLength: {
//                     min: 7,
//                     max: 15,
//                     message: 'The number should contain 7 to 15 digit'
//                 },
//             },
//         },
               
//         password: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please supply your password'
//                 },
//                 /*stringLength: {
//                 min: 6,
//                 max: 16,
//                 message: 'The password should contain 6 to 16 characters'
//                 },*/
//                 },                
//                 regexp: {
//                     regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
//                     message: 'Your password must be more than 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
//                 } 
//             },
        
//         password_confirmation: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter password confirmation'
//                 },
//                 identical: {
//                     field: 'password',
//                     message: 'The password and its confirm are not the same'
//                 }
//             }
//         },           
//        }
        
//     });    
// //});

// $('#category').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 },
//             },
//         }
//     }
// });

// $('#faq_cat').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 },
//             },
//         }
//     }
// });

// $('#article_admin1').bootstrapValidator({
//     fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 },
//             },
//         },
//         category_id: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select the category'
//                 },
//             },
//         },
//         content: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter the content'
//                 },
//             },
//         }
//     }
// });

// $('#bannerform').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         category_id: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select category.'
//                 },                  
//             },                            
             
//         },
//         photo: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select photo.'
//                 },                 
//                 file: {
//                     extension: 'jpg,png,jpeg',
//                     type: 'image/jpeg,image/jpg,image/png',
//                     maxSize: 2048 * 1024,
//                     message: 'The selected file is not valid'
//                 },                 
//             },                            
             
//         },
//     },
// });

// $('#page_admin').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         slug: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter slug'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The slug should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         icon: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter icon'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The icon should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         title: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter title'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The title should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         description: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter description'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The description should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
      
//     },
// });

// $('#newscategory').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter category'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The category should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
        
      
//     },
// });

// $('#career').bootstrapValidator({
//      fields: {
//         title: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter title'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The title should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//            location: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter location'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The location should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         city: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter location'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The city should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         zipcode: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter zipcode'
//                 }, 
//                stringLength: {
//                     min: 3,
//                     max: 10,
//                     message: 'zipcode length between 3 to 10'
//                 },           
//             },                            
             
//         },
        
//            type: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter type'
//                 },                
//             },                            
             
//         },
//            description: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter category'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     message: 'The description should contain minimum 3 characters'
//                 },                
//             },                            
             
//         },
        
        
      
//     },
// });


// $('#charges').bootstrapValidator({
//      fields: {
//         pickanddrop: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter price'
//                 },
//                 integer:{
//                     message:'Please enter numeric'
//                 },
//                 stringLength: {
//                     min: 1,
//                     max: 15,
//                     message: 'The price should contain 1 to 15 digit'
//                 },
//             },
//         },       
//         mailin: {
//             validators: {
//               notEmpty: {
//                     message: 'Please enter price'
//                 },
//                 integer:{
//                     message:'Please enter numeric'
//                 },
//                 stringLength: {
//                     min: 1,
//                     max: 15,
//                     message: 'The price should contain 1 to 15 digit'
//                 },             
//             },
//         },
//         tampered: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter price'
//                 },
//                 integer:{
//                     message:'Please enter numeric'
//                 },
//                 stringLength: {
//                     min: 1,
//                     max: 15,
//                     message: 'The price should contain 1 to 15 digit'
//                 },             
//             },
//         },
        
      
//     },
// });


// $('#milesprice').bootstrapValidator({
//      fields: {
//         miles: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter miles'
//                 },
//                 integer:{
//                     message:'Please enter numeric'
//                 },
//                 stringLength: {
//                     min: 1,
//                     max: 15,
//                     message: 'The miles should contain 1 to 15 digit'
//                 },
//             },
//         },       
//         price: {
//             validators: {
//               notEmpty: {
//                     message: 'Please enter price'
//                 },
//                 integer:{
//                     message:'Please enter numeric'
//                 },
//                 stringLength: {
//                     min: 1,
//                     max: 15,
//                     message: 'The price should contain 1 to 15 digit'
//                 },             
//             },
//         }
      
//     },
// });



// $('#form-edit').bootstrapValidator({
//      fields: {
//         icon: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter icon'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The icon should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//         description: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter description'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 550,
//                     message: 'The description should contain 3 to 550 characters'
//                 },                
//             },                            
             
//         },
        
        
      
//     },
// });
// $('#branchManagement').bootstrapValidator({
//      fields: {
     
//         branch_name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter branch name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The branch name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//         services: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter services'
//                 },                
//             },                            
             
//         },
//        postcode: {
//             validators: {
//                  notEmpty: {
//                     message: 'Please enter postcode'
//                 },
//                 stringLength: {
//                     min: 3,
//                     max: 10,
//                     message: 'postcode length between 3 to 10'
//                 }
//             }
//         },  
        
      
//     },
// });

// $('#role_admin').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         slug: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter slug'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The slug should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//         keyword: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter keyword'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The keyword should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
        
        
      
//     },
// });




// $('#article_admin').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         category_id: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter category'
//                 }, 
//                 // stringLength: {
//                 //     min: 3,                  
//                 //     max: 55,
//                 //     message: 'The category should contain 3 to 55 characters'
//                 // },                
//             },                            
             
//         },

//         content: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter content'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The content should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
        
        
      
//     },
// });


// $('#shop_cat').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//     photo: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please select photo.'
//                 },                 
//                 file: {
//                     extension: 'jpg,png,jpeg',
//                     type: 'image/jpeg,image/jpg,image/png',
//                     maxSize: 255 * 255,
//                     message: 'The selected file is not valid'
//                 },                 
//             },                            
             
          
//     },
// }
// });

// $('#faq_admin').bootstrapValidator({
//      fields: {
//         question: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         caregory_id: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter Question'
//                 },               
//             },                            
             
//         },
      
//     },
// });

// $('#status').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         category: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter badge'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The badge should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//     },
// });

// $('#shop_cat').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//     },
// });

// $('#features').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter feature'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The feature should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//     },
// });


// $('#email').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//         action: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
                             
//             },                            
             
//         },
//         // body: {
//         //     validators: {
//         //         notEmpty: {
//         //             message: 'Please enter body'
//         //         }, 
//         //         stringLength: {
//         //             min: 3,                  
//         //             max: 550,
//         //             message: 'The body should contain 3 to 550 characters'
//         //         },                
//         //     },                            
             
//         // },
//         subject: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter subject'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The subject should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },

//     },
// });





// $('#plan_admin').bootstrapValidator({
//      fields: {
//         name: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter name'
//                 }, 
//                 stringLength: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'The name should contain 3 to 55 characters'
//                 },                
//             },                            
             
//         },
//          description: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter description'
//                 }, 
//                 integer: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'Please enter numeric'
//                 },                
//             },                            
             
//         },
//         duration: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter duration'
//                 }, 
//                 integer: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'Please enter numeric'
//                 },                
//             },                            
             
//         },
//         amount: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter amount'
//                 }, 
//                 integer: {
//                     min: 3,                  
//                     max: 55,
//                     message: 'Please enter numeric'
//                 },                
//             },                            
             
//         },
//     },
// });

// /*techrepair end */


// $('#LoginForm,#login-form-popup').bootstrapValidator({
//      fields: {
//         username: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please enter your username'
//                 },

//             },
//         },
//         password: {
//             validators: {                       
//                 notEmpty: {
//                     message: 'Please enter your password'
//                 }
//             }
//         }
//     }
// });


// $('#cart').bootstrapValidator({
//     fields: {
//        username: {
//            validators: {
//                notEmpty: {
//                    message: 'Please enter your username'
//                },

//            },
//        },
//        password: {
//            validators: {                       
//                notEmpty: {
//                    message: 'Please enter your password'
//                }
//            }
//        }
//    }
// });



/* End Tech repair validations*/

$("#order-form")
.bootstrapValidator()
.change(function(e){      
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('email', 'NOT_VALIDATED')
        .validateField('email');
})
.end();

$("#order-form")
.bootstrapValidator()
.change(function(e){    
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('buyer_email', 'NOT_VALIDATED')
        .validateField('buyer_email');
})
.end();

$("#order-form")
.bootstrapValidator()
.change(function(e){    
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('name', 'NOT_VALIDATED')
        .validateField('name');
})
.end();

$("#order-form")
.bootstrapValidator()
.change(function(e){    
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('mobile_number', 'NOT_VALIDATED')
        .validateField('mobile_number');
})
.end();

$("#order-form")
.bootstrapValidator()
.change(function(e){    
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('buyer_name', 'NOT_VALIDATED')
        .validateField('buyer_name');
})
.end();

$("#order-form")
.bootstrapValidator()
.change(function(e){    
    $(".bv-form")
        .data("bootstrapValidator")
        .updateStatus('buyer_phone', 'NOT_VALIDATED')
        .validateField('buyer_phone');
})
.end();

/*$("#order-form").on("click", function(){

   var bootstrapValidator = $("#order-form").data('bootstrapValidator');
   bootstrapValidator.validate();
    if(bootstrapValidator.isValid()){
        $('.loader').show() 
        $('.overlay_loader').show() 
        return true; 
    } 
   

});*/






   
              
});// end document




