import{av as T,K as A,r as d,e as C,c as j,b as a,w as t,aw as L,k as b,o as U,a as u,u as e,j as _,am as B,W as V,Y as M,A as N,J as S,U as D,s as c}from"./main-DHXZBRQ4.js";import{r as g}from"./rules-B5G8qOzK.js";import{l as E}from"./eduall-jXBsxaj5.js";import{a as P,b as F}from"./auth-v1-mask-light--N6hHkxK.js";import{V as I,d as J,b as W,a as w}from"./VCard--A0TG-0k.js";import{V as Y}from"./VForm-BfOoJ6Eg.js";import{V as q,a as K}from"./VRow-C9FP_fFb.js";import"./VAvatar-77KL_Eez.js";import"./VImg-DDxq5_W8.js";const R={class:"auth-wrapper d-flex align-center justify-center pa-4"},$={class:"d-flex justify-center mb-5"},z=["src"],G=u("h5",{class:"text-h5 font-weight-semibold mb-1"},"Welcome to Timesheet App! 👋🏻",-1),H=u("p",{class:"mb-0"},"Please sign-in to your account and start the adventure",-1),le={__name:"login-admin",setup(O){const y=T();A(()=>y.global.name.value==="light"?P:F);const p=d(),l=d({email:"",password:""}),i=d(!1),n=d(!1),x=async()=>{var s,r,f,h,v;const{valid:m}=await p.value.validate();if(m)try{i.value=!0;const o=await N.post("api/v1/auth/token",l.value);o&&(S.saveToken(o.granted_token),D.saveUser(o),c("success","You`ve successfully login.","bottom-end"),setTimeout(()=>{b.go("/admin/dashboard")},1500)),i.value=!1}catch(o){typeof o.response.data.errors=="object"?c("error",(f=(r=(s=o.response)==null?void 0:s.data)==null?void 0:r.errors)==null?void 0:f.email,"bottom-end"):c("error",(v=(h=o.response)==null?void 0:h.data)==null?void 0:v.errors,"bottom-end"),i.value=!1,console.error(o)}},k=()=>{L().isAuthenticated.value&&b.push("/admin/dashboard")};return C(()=>{k()}),(m,s)=>(U(),j("div",R,[a(I,{class:"auth-card pa-4 pt-7","max-width":"448"},{default:t(()=>[a(J,{class:"justify-center"},{default:t(()=>[u("div",$,[u("img",{src:e(E),alt:"Timesheet - EduALL",class:"w-50 text-center"},null,8,z)]),a(W,{class:"font-weight-semibold text-2xl text-uppercase"},{default:t(()=>[_(" Timesheet App ")]),_:1})]),_:1}),a(w,{class:"pt-2 text-center"},{default:t(()=>[G,H]),_:1}),a(w,null,{default:t(()=>[a(Y,{onSubmit:B(x,["prevent"]),ref_key:"formData",ref:p,"validate-on":"input","fast-fail":""},{default:t(()=>[a(q,null,{default:t(()=>[a(K,{cols:"12"},{default:t(()=>[a(V,{modelValue:e(l).email,"onUpdate:modelValue":s[0]||(s[0]=r=>e(l).email=r),label:"Email",type:"email",class:"mb-3",rules:e(g).email},null,8,["modelValue","rules"]),a(V,{modelValue:e(l).password,"onUpdate:modelValue":s[1]||(s[1]=r=>e(l).password=r),label:"Password",placeholder:"············",type:e(n)?"text":"password","append-inner-icon":e(n)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":s[2]||(s[2]=r=>n.value=!e(n)),class:"mb-5",rules:e(g).required},null,8,["modelValue","type","append-inner-icon","rules"]),a(M,{block:"",type:"submit",loading:e(i),disabled:e(i)},{default:t(()=>[_(" Login ")]),_:1},8,["loading","disabled"])]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})]))}};export{le as default};
