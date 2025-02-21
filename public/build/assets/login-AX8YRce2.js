import{a6 as Y,K as F,r as m,e as $,c as J,b as t,w as l,a7 as R,k as C,l as W,o as p,a as v,u as e,j as c,f as y,W as f,Y as V,Z as P,h as T,A as _,s as g,J as q,U as K}from"./main-BFoIPluG.js";import{r as k}from"./rules-B5G8qOzK.js";import{l as Z}from"./eduall-jXBsxaj5.js";import{a as z,b as G}from"./auth-v1-mask-light--N6hHkxK.js";import{V as H,d as O,b as Q,a as A}from"./VCard-B2hWxLsQ.js";import{V as U,a as h}from"./VRow-CfasLNgG.js";import{V as N}from"./VForm-B42YDyMM.js";import"./VAvatar-ylYqmFp1.js";import"./VImg-Ce3gVw-b.js";const X={class:"auth-wrapper d-flex align-center justify-center pa-4"},ee={class:"d-flex justify-center mb-5"},ae=["src"],se=v("h5",{class:"text-h5 font-weight-semibold mb-1"},"Welcome to Timesheet App! 👋🏻",-1),te=v("p",{class:"mb-0"},"Please sign-in to your account and start the adventure",-1),le={class:"d-flex align-center justify-end flex-wrap my-2"},fe={__name:"login",props:{token:String,email:String},setup(S){const E=Y();F(()=>E.global.name.value==="light"?z:G);const w=S,b=m(),s=m({token:"",email:"",password:"",password_confirmation:""}),o=m(!1),u=m(!1),d=m(!0),r=m(!1),j=[n=>n!==s.value.password?"Passwords do not match":!0],B=async()=>{const{valid:n}=await b.value.validate();if(n){o.value=!0;try{const a=await _.post("api/v1/auth/email/checking",{email:s.value.email});a&&(u.value=!0,a.has_password?d.value=!0:d.value=!1),o.value=!1}catch(a){g("error","You`re email is not found!","bottom-end"),console.error(a),o.value=!1}}},x=async()=>{const{valid:n}=await b.value.validate();if(n){o.value=!0;try{if(d.value){const a=await _.post("api/v1/identity/generate-token",{email:s.value.email,password:s.value.password});a&&(q.saveToken(a.granted_token),K.saveUser(a),g("success","You`ve successfully login.","bottom-end"),setTimeout(()=>{C.go(0)},1500))}else await L();o.value=!1}catch(a){s.value.password="",g("error","You`re password is wrong.","bottom-end"),console.error(a),o.value=!1}}},L=async()=>{try{const n=w.token?"api/v1/auth/reset-password":"api/v1/auth/create-password";await _.post(n,s.value)&&(d.value=!0,await x())}catch(n){console.error(n)}},D=()=>{s.value.email=w.email,s.value.token=w.token,u.value=!0,d.value=!1},I=()=>{R().isAuthenticated.value&&C.push("/user/dashboard")};return $(()=>{I(),w.token&&D()}),(n,a)=>{const M=W("router-link");return p(),J("div",X,[t(H,{class:"auth-card pa-4 pt-7","max-width":"448"},{default:l(()=>[t(O,{class:"justify-center"},{default:l(()=>[v("div",ee,[v("img",{src:e(Z),alt:"Timesheet - EduALL",class:"w-50 text-center"},null,8,ae)]),t(Q,{class:"font-weight-semibold text-2xl text-uppercase"},{default:l(()=>[c(" Timesheet App ")]),_:1})]),_:1}),t(A,{class:"pt-2 text-center"},{default:l(()=>[se,te]),_:1}),t(A,null,{default:l(()=>[e(u)?(p(),y(N,{key:1,ref_key:"formData",ref:b,onSubmit:P(x,["prevent"]),"validate-on":"input","fast-fail":""},{default:l(()=>[t(U,null,{default:l(()=>[t(h,{cols:"12"},{default:l(()=>[t(f,{modelValue:e(s).email,"onUpdate:modelValue":a[1]||(a[1]=i=>e(s).email=i),label:"Email",type:"email",disabled:e(u),rules:e(k).email},null,8,["modelValue","disabled","rules"])]),_:1}),e(d)?(p(),y(h,{key:0,cols:"12"},{default:l(()=>[t(f,{modelValue:e(s).password,"onUpdate:modelValue":a[2]||(a[2]=i=>e(s).password=i),label:"Password",placeholder:"············",type:e(r)?"text":"password","append-inner-icon":e(r)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":a[3]||(a[3]=i=>r.value=!e(r)),rules:e(k).required},null,8,["modelValue","type","append-inner-icon","rules"]),v("div",le,[t(M,{to:"/user/forgot",class:"ms-2 mb-1"},{default:l(()=>[c(" Forgot Password? ")]),_:1})]),t(V,{block:"",type:"submit",loading:e(o),disabled:e(o)},{default:l(()=>[c(" Login ")]),_:1},8,["loading","disabled"])]),_:1})):T("",!0),e(u)&&!e(d)?(p(),y(h,{key:1,cols:"12"},{default:l(()=>[t(f,{modelValue:e(s).password,"onUpdate:modelValue":a[4]||(a[4]=i=>e(s).password=i),label:"New Password",placeholder:"············",type:e(r)?"text":"password","append-inner-icon":e(r)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":a[5]||(a[5]=i=>r.value=!e(r)),rules:e(k).password,class:"mb-6"},null,8,["modelValue","type","append-inner-icon","rules"]),t(f,{modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[6]||(a[6]=i=>e(s).password_confirmation=i),label:"Confirmation Password",placeholder:"············",type:e(r)?"text":"password","append-inner-icon":e(r)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":a[7]||(a[7]=i=>r.value=!e(r)),class:"mb-6",rules:j},null,8,["modelValue","type","append-inner-icon"]),t(V,{block:"",type:"submit",loading:e(o),disabled:e(o)},{default:l(()=>[c(" Create New Password ")]),_:1},8,["loading","disabled"])]),_:1})):T("",!0)]),_:1})]),_:1},512)):(p(),y(N,{key:0,ref_key:"formData",ref:b,onSubmit:P(B,["prevent"])},{default:l(()=>[t(U,null,{default:l(()=>[t(h,{cols:"12"},{default:l(()=>[t(f,{modelValue:e(s).email,"onUpdate:modelValue":a[0]||(a[0]=i=>e(s).email=i),label:"Email",type:"email",disabled:e(u),rules:e(k).email},null,8,["modelValue","disabled","rules"]),t(V,{block:"",type:"submit",class:"mt-4",loading:e(o),disabled:e(o)},{default:l(()=>[c(" Check Email ")]),_:1},8,["loading","disabled"])]),_:1})]),_:1})]),_:1},512))]),_:1})]),_:1})])}}};export{fe as default};
