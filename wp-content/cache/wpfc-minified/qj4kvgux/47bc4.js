function regexPhoneNumber(str){
const regexPhoneNumber=/^((\+)33|0)[1-9](\d{2}){4}$/;
if(str.match(regexPhoneNumber)){
return true;
}else{
return false;
}}
let phoneNumber=document.querySelector("#billing_phone").value;
console.log(phoneNumber);