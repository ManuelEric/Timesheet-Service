import{a6 as T,K as A,r as d,e as C,c as j,b as a,w as t,a7 as L,k as _,o as U,a as u,u as e,j as b,Z as B,W as V,Y as M,A as N,J as S,U as D,s as m}from"./main-hx09Hrpa.js";import{r as g}from"./rules-B5G8qOzK.js";import{l as E}from"./eduall-jXBsxaj5.js";import{a as P,b as F}from"./auth-v1-mask-light--N6hHkxK.js";import{V as I,d as J,b as W,a as w}from"./VCard-D7fXvrE8.js";import{V as Y}from"./VForm-TiMvonFV.js";import{V as q,a as K}from"./VRow-CVTsRxDz.js";import"./VAvatar-Da3c__KI.js";import"./VImg-CgRfhXmv.js";const R={class:"auth-wrapper d-flex align-center justify-center pa-4"},Z={class:"d-flex justify-center mb-5"},$=["src"],z=u("h5",{class:"text-h5 font-weight-semibold mb-1"},"Welcome to Timesheet App! 👋🏻",-1),G=u("p",{class:"mb-0"},"Please sign-in to your account and start the adventure",-1),re={__name:"login-admin",setup(H){const y=T();A(()=>y.global.name.value==="light"?P:F);const p=d(),r=d({email:"",password:""}),i=d(!1),n=d(!1),x=async()=>{var s,l,f,h,v;const{valid:c}=await p.value.validate();if(c)try{i.value=!0;const o=await N.post("api/v1/auth/token",r.value);o&&(S.saveToken(o.granted_token),D.saveUser(o),m("success","You`ve successfully login.","bottom-end"),setTimeout(()=>{_.go(0)},1500)),i.value=!1}catch(o){typeof o.response.data.errors=="object"?m("error",(f=(l=(s=o.response)==null?void 0:s.data)==null?void 0:l.errors)==null?void 0:f.email,"bottom-end"):m("error",(v=(h=o.response)==null?void 0:h.data)==null?void 0:v.errors,"bottom-end"),i.value=!1,console.error(o)}},k=()=>{L().isAuthenticated.value&&_.push("/admin/dashboard")};return C(()=>{k()}),(c,s)=>(U(),j("div",R,[a(I,{class:"auth-card pa-4 pt-7","max-width":"448"},{default:t(()=>[a(J,{class:"justify-center"},{default:t(()=>[u("div",Z,[u("img",{src:e(E),alt:"Timesheet - EduALL",class:"w-50 text-center"},null,8,$)]),a(W,{class:"font-weight-semibold text-2xl text-uppercase"},{default:t(()=>[b(" Timesheet App ")]),_:1})]),_:1}),a(w,{class:"pt-2 text-center"},{default:t(()=>[z,G]),_:1}),a(w,null,{default:t(()=>[a(Y,{onSubmit:B(x,["prevent"]),ref_key:"formData",ref:p,"validate-on":"input","fast-fail":""},{default:t(()=>[a(q,null,{default:t(()=>[a(K,{cols:"12"},{default:t(()=>[a(V,{modelValue:e(r).email,"onUpdate:modelValue":s[0]||(s[0]=l=>e(r).email=l),label:"Email",type:"email",class:"mb-3",rules:e(g).email},null,8,["modelValue","rules"]),a(V,{modelValue:e(r).password,"onUpdate:modelValue":s[1]||(s[1]=l=>e(r).password=l),label:"Password",placeholder:"············",type:e(n)?"text":"password","append-inner-icon":e(n)?"ri-eye-off-line":"ri-eye-line","onClick:appendInner":s[2]||(s[2]=l=>n.value=!e(n)),class:"mb-5",rules:e(g).required},null,8,["modelValue","type","append-inner-icon","rules"]),a(M,{block:"",type:"submit",loading:e(i),disabled:e(i)},{default:t(()=>[b(" Login ")]),_:1},8,["loading","disabled"])]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})]))}};export{re as default};
