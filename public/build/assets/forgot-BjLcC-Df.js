import{av as T,K as S,r as i,e as C,c as v,b as e,w as t,l as h,o as g,a as n,u as a,j as f,am as D,W as I,Y as M,t as N,h as L,A as P,s as w}from"./main-CCxSbBwX.js";import{r as j}from"./rules-B5G8qOzK.js";import{l as A}from"./eduall-jXBsxaj5.js";import{a as B,b as E}from"./auth-v1-mask-light--N6hHkxK.js";import{V as R,d as F,b as Y,a as b}from"./VCard-BoLn1wH5.js";import{V as K}from"./VForm-CY1asll7.js";import{V as U,a as V}from"./VRow-C5xB1PZW.js";import{V as W}from"./VDivider-DwNWTBcy.js";import"./VAvatar-Dudg9Spz.js";import"./VImg-DfdngGeG.js";const q={class:"auth-wrapper d-flex align-center justify-center pa-4"},z={class:"d-flex justify-center mb-5"},G=["src"],H=n("h5",{class:"text-h5 font-weight-semibold mb-1"},"Forgot Password",-1),J=n("p",{class:"mb-0"},"Please enter your email address to receive the verification link.",-1),O={key:0,class:"text-center mt-4"},Q=n("span",null,"I've Remembered,",-1),ne={__name:"forgot",setup(X){const x=T();S(()=>x.global.name.value==="light"?B:E);const _=i(),l=i({email:""}),r=i(!1),m=i(0),s=i(!1),y=async()=>{const{valid:d}=await _.value.validate();if(d){r.value=!0;try{if(await P.post("api/v1/auth/forgot-password",l.value)){var o=new Date,c=new Date(o.getTime()+20*1e3);localStorage.setItem("new_date",Math.floor(c.getTime()/1e3)),localStorage.setItem("email",l.value.email),m.value=Math.floor(c.getTime()/1e3)-Math.floor(o.getTime()/1e3),s.value=!0,w("success","Please check your inbox and follow the instructions to reset your password.","bottom-end")}r.value=!1}catch(u){console.log(u),w("error","You`re email is not found.","bottom-end"),r.value=!1}}},k=()=>{m.value=0,s.value=!1,localStorage.removeItem("new_date")};return C(()=>{if(localStorage.getItem("new_date")){s.value=!0,l.value.email=localStorage.getItem("email");var d=localStorage.getItem("new_date"),o=d-Math.floor(new Date().getTime()/1e3);m.value=o}}),(d,o)=>{const c=h("vue-countdown"),u=h("RouterLink");return g(),v("div",q,[e(R,{class:"auth-card pa-4 pt-7","max-width":"448"},{default:t(()=>[e(F,{class:"justify-center"},{default:t(()=>[n("div",z,[n("img",{src:a(A),alt:"Timesheet - EduALL",class:"w-50 text-center"},null,8,G)]),e(Y,{class:"font-weight-semibold text-2xl text-uppercase"},{default:t(()=>[f(" Timesheet App ")]),_:1})]),_:1}),e(b,{class:"pt-2 text-center"},{default:t(()=>[H,J]),_:1}),e(b,null,{default:t(()=>[e(K,{onSubmit:D(y,["prevent"]),ref_key:"formData",ref:_,"validate-on":"input","fast-fail":""},{default:t(()=>[e(U,null,{default:t(()=>[e(V,{cols:"12"},{default:t(()=>[e(I,{modelValue:a(l).email,"onUpdate:modelValue":o[0]||(o[0]=p=>a(l).email=p),label:"Email",type:"email",class:"mb-3",disabled:a(s),rules:a(j).email},null,8,["modelValue","disabled","rules"]),e(M,{block:"",type:"submit",loading:a(r),disabled:a(r)||a(s)},{default:t(()=>[f(" Send ")]),_:1},8,["loading","disabled"]),a(s)?(g(),v("div",O,[e(c,{time:a(m)*1e3,onEnd:k},{default:t(({seconds:p})=>[f(" Please wait to resend verification link: "+N(p)+"s ",1)]),_:1},8,["time"])])):L("",!0)]),_:1}),e(V,{cols:"12",class:"text-center text-base"},{default:t(()=>[e(W,{class:"mb-3"}),Q,e(u,{class:"text-primary ms-1",to:"login"},{default:t(()=>[f(" Sign in Now ")]),_:1})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})])}}};export{ne as default};
