import{a6 as b,o as x,c as v,X as w,b as e,u as o,Y as y,F as T,r as _,K as C,w as a,l as I,a as l,j as u,Z as P,W as m,bP as L}from"./main-qXfsbDxV.js";import{l as M}from"./logo-DbYPuVAr.js";import{a as D,b as j}from"./auth-v1-mask-light--N6hHkxK.js";import{V as B,d as F,b as U,a as h}from"./VCard-0nDPb5C9.js";import{V as p}from"./VImg-DfdL-2nd.js";import{V as R}from"./VForm-uuZu4Soy.js";import{V as A,a as n}from"./VRow-CZMaU6Db.js";import{V as H}from"./VCheckbox-B19lrrk6.js";import{V}from"./VDivider-BlZqtOM7.js";import"./VAvatar-8XWfWrYa.js";import"./VCheckboxBtn-sQZtdDVL.js";import"./VSelectionControl-DsOh91CE.js";const N={__name:"AuthProvider",setup(g){const{global:t}=b(),c=[{icon:"bxl-facebook",color:"#4267b2",colorInDark:"#4267b2"},{icon:"bxl-twitter",color:"#1da1f2",colorInDark:"#1da1f2"},{icon:"bxl-github",color:"#272727",colorInDark:"#fff"},{icon:"bxl-google",color:"#db4437",colorInDark:"#db4437"}];return(f,i)=>(x(),v(T,null,w(c,d=>e(y,{key:d.icon,icon:d.icon,variant:"text",color:o(t).name.value==="dark"?d.colorInDark:d.color},null,8,["icon","color"])),64))}},S="/build/assets/auth-v1-tree-2-Cg13PFRH.png",E="/build/assets/auth-v1-tree-XwsB2ezL.png",X={class:"auth-wrapper d-flex align-center justify-center pa-4"},$={class:"d-flex"},z=["innerHTML"],J=l("h5",{class:"text-h5 font-weight-semibold mb-1"}," Adventure starts here 🚀 ",-1),K=l("p",{class:"mb-0"}," Make your app management easy and fun! ",-1),W={class:"d-flex align-center mt-1 mb-4"},Y=l("span",{class:"me-1"},"I agree to",-1),Z=l("a",{href:"javascript:void(0)",class:"text-primary"},"privacy policy & terms",-1),q=l("span",null,"Already have an account?",-1),G=l("span",{class:"mx-4"},"or",-1),ce={__name:"register",setup(g){const t=_({username:"",email:"",password:"",privacyPolicies:!1}),c=b(),f=C(()=>c.global.name.value==="light"?D:j),i=_(!1);return(d,s)=>{const k=I("RouterLink");return x(),v("div",X,[e(B,{class:"auth-card pa-4 pt-7","max-width":"448"},{default:a(()=>[e(F,{class:"justify-center"},{prepend:a(()=>[l("div",$,[l("div",{innerHTML:o(M)},null,8,z)])]),default:a(()=>[e(U,{class:"font-weight-semibold text-2xl text-uppercase"},{default:a(()=>[u(" Materio ")]),_:1})]),_:1}),e(h,{class:"pt-2"},{default:a(()=>[J,K]),_:1}),e(h,null,{default:a(()=>[e(R,{onSubmit:P(()=>{},["prevent"])},{default:a(()=>[e(A,null,{default:a(()=>[e(n,{cols:"12"},{default:a(()=>[e(m,{modelValue:o(t).username,"onUpdate:modelValue":s[0]||(s[0]=r=>o(t).username=r),label:"Username",placeholder:"Johndoe"},null,8,["modelValue"])]),_:1}),e(n,{cols:"12"},{default:a(()=>[e(m,{modelValue:o(t).email,"onUpdate:modelValue":s[1]||(s[1]=r=>o(t).email=r),label:"Email",placeholder:"johndoe@email.com",type:"email"},null,8,["modelValue"])]),_:1}),e(n,{cols:"12"},{default:a(()=>[e(m,{modelValue:o(t).password,"onUpdate:modelValue":s[2]||(s[2]=r=>o(t).password=r),label:"Password",placeholder:"············",type:o(i)?"text":"password","append-inner-icon":o(i)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":s[3]||(s[3]=r=>i.value=!o(i))},null,8,["modelValue","type","append-inner-icon"]),l("div",W,[e(H,{id:"privacy-policy",modelValue:o(t).privacyPolicies,"onUpdate:modelValue":s[4]||(s[4]=r=>o(t).privacyPolicies=r),inline:""},null,8,["modelValue"]),e(L,{for:"privacy-policy",style:{opacity:"1"}},{default:a(()=>[Y,Z]),_:1})]),e(y,{block:"",type:"submit",to:"/"},{default:a(()=>[u(" Sign up ")]),_:1})]),_:1}),e(n,{cols:"12",class:"text-center text-base"},{default:a(()=>[q,e(k,{class:"text-primary ms-2",to:"login"},{default:a(()=>[u(" Sign in instead ")]),_:1})]),_:1}),e(n,{cols:"12",class:"d-flex align-center"},{default:a(()=>[e(V),G,e(V)]),_:1}),e(n,{cols:"12",class:"text-center"},{default:a(()=>[e(N)]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(p,{class:"auth-footer-start-tree d-none d-md-block",src:o(E),width:250},null,8,["src"]),e(p,{src:o(S),class:"auth-footer-end-tree d-none d-md-block",width:350},null,8,["src"]),e(p,{class:"auth-footer-mask d-none d-md-block",src:o(f)},null,8,["src"])])}}};export{ce as default};
