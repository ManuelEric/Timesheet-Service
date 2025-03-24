import{Z as me,B as pe,$ as ve,a0 as fe,a1 as _e,a2 as ge,a3 as be,a4 as ye,a5 as Ve,a6 as ke,a7 as xe,a8 as he,a9 as Ce,D as we,E as Pe,K as J,aa as je,ab as Te,ac as Se,ad as qe,ae as Ue,af as Ie,ag as $e,ah as Ne,ai as Ae,aj as De,ak as Be,b as l,al as Me,V as j,Q as oe,Y as K,P as Le,r as p,e as ee,o as y,f as C,w as t,am as se,u as e,z as Y,a as k,t as O,h as H,W,j as E,m as ne,A as U,s as X,an as Fe,l as Ee,x as Re,c as Q,X as ze,F as Oe,n as Ge}from"./main-DHXZBRQ4.js";import{r as T}from"./rules-B5G8qOzK.js";import{a as le,c as re,V as ae,b as He}from"./VCard--A0TG-0k.js";import{V as ie}from"./VForm-BfOoJ6Eg.js";import{V as te,a as V}from"./VRow-C9FP_fFb.js";import{V as R}from"./VAutocomplete-DHKBwZi_.js";import{V as ue}from"./VTextarea-CZCO8IJU.js";import{d as We}from"./debounce-DFd21Ooa.js";import{V as Ye}from"./VDialog-BrfHzCJR.js";import{V as Ke,a as Qe}from"./VTable-BFBWHWKR.js";import{V as Xe}from"./VPagination-DYSV3PuI.js";import{T as Ze}from"./index-KLSjLqT0.js";import{V as Z}from"./VTooltip-BXaDluYK.js";import{V as Je}from"./VCheckbox-BtW0HssN.js";import"./VAvatar-77KL_Eez.js";import"./VImg-DDxq5_W8.js";import"./VList-jQSCjwsh.js";import"./ssrBoot-CWo8AL0y.js";import"./VDivider-CXdawh1a.js";import"./VCheckboxBtn-BomQkkUg.js";import"./VSelectionControl-U3dUhfvP.js";import"./VSlideGroup-C7nR5XIS.js";const el=me("v-alert-title"),ll=["success","info","warning","error"],al=pe({border:{type:[Boolean,String],validator:o=>typeof o=="boolean"||["top","end","bottom","start"].includes(o)},borderColor:String,closable:Boolean,closeIcon:{type:ve,default:"$close"},closeLabel:{type:String,default:"$vuetify.close"},icon:{type:[Boolean,String,Function,Object],default:null},modelValue:{type:Boolean,default:!0},prominent:Boolean,title:String,text:String,type:{type:String,validator:o=>ll.includes(o)},...fe(),..._e(),...ge(),...be(),...ye(),...Ve(),...ke(),...xe(),...he(),...Ce({variant:"flat"})},"VAlert"),de=we()({name:"VAlert",props:al(),emits:{"click:close":o=>!0,"update:modelValue":o=>!0},setup(o,w){let{emit:S,slots:d}=w;const c=Pe(o,"modelValue"),_=J(()=>{if(o.icon!==!1)return o.type?o.icon??`$${o.type}`:o.icon}),B=J(()=>({color:o.color??o.type,variant:o.variant})),{themeClasses:z}=je(o),{colorClasses:h,colorStyles:M,variantClasses:I}=Te(B),{densityClasses:P}=Se(o),{dimensionStyles:$}=qe(o),{elevationClasses:N}=Ue(o),{locationStyles:L}=Ie(o),{positionClasses:r}=$e(o),{roundedClasses:a}=Ne(o),{textColorClasses:A,textColorStyles:x}=Ae(De(o,"borderColor")),{t:G}=Be(),v=J(()=>({"aria-label":G(o.closeLabel),onClick(F){c.value=!1,S("click:close",F)}}));return()=>{const F=!!(d.prepend||_.value),D=!!(d.title||o.title),q=!!(d.close||o.closable);return c.value&&l(o.tag,{class:["v-alert",o.border&&{"v-alert--border":!!o.border,[`v-alert--border-${o.border===!0?"start":o.border}`]:!0},{"v-alert--prominent":o.prominent},z.value,h.value,P.value,N.value,r.value,a.value,I.value,o.class],style:[M.value,$.value,L.value,o.style],role:"alert"},{default:()=>{var f,m;return[Me(!1,"v-alert"),o.border&&l("div",{key:"border",class:["v-alert__border",A.value],style:x.value},null),F&&l("div",{key:"prepend",class:"v-alert__prepend"},[d.prepend?l(oe,{key:"prepend-defaults",disabled:!_.value,defaults:{VIcon:{density:o.density,icon:_.value,size:o.prominent?44:28}}},d.prepend):l(j,{key:"prepend-icon",density:o.density,icon:_.value,size:o.prominent?44:28},null)]),l("div",{class:"v-alert__content"},[D&&l(el,{key:"title"},{default:()=>{var n;return[((n=d.title)==null?void 0:n.call(d))??o.title]}}),((f=d.text)==null?void 0:f.call(d))??o.text,(m=d.default)==null?void 0:m.call(d)]),d.append&&l("div",{key:"append",class:"v-alert__append"},[d.append()]),q&&l("div",{key:"close",class:"v-alert__close"},[d.close?l(oe,{key:"close-defaults",defaults:{VBtn:{icon:o.closeIcon,size:"x-small",variant:"text"}}},{default:()=>{var n;return[(n=d.close)==null?void 0:n.call(d,{props:v.value})]}}):l(K,Le({key:"close-btn",icon:o.closeIcon,size:"x-small",variant:"text"},v.value),null)])]}})}}}),tl={__name:"program_add",props:{selected:Object},emits:["close","reload"],setup(o,{emit:w}){var m,n;const S=o,d=w,c=p(!1),_=p([]);p([]);const B=p([]),z=p([]),h=p([]),M=p([]),I=p([]),P=p([]),$=p(!1),N=(n=(m=S.selected[0])==null?void 0:m.require)==null?void 0:n.toLowerCase(),L=p(null),r=p(),a=p({ref_id:S.selected.map(s=>s.id),mentortutor_email:null,subject_id:null,inhouse_id:null,package_id:null,tax:null,individual_fee:null,duration:"",notes:"",pic_id:[],curriculum_id:null}),A=async(s=!1)=>{const i=s?"api/v1/user/mentor-tutors?inhouse=true&role="+N:"api/v1/user/mentor-tutors?role="+N;try{const b=await U.get(i);b&&(s?P.value=Object.values(b):B.value=b)}catch(b){console.error(b)}},x=async()=>{try{const s=await U.get("api/v1/package/component/list?category="+N);s&&(M.value=s)}catch(s){console.error(s)}},G=()=>{const s=a.value.package_id,i=M.value.findIndex(g=>g.id===s);let b=M.value[i];b.detail?($.value=!0,a.value.duration=b.detail):($.value=!1,a.value.duration=null)},v=async()=>{try{const s=await U.get("api/v1/user/component/list");s&&(I.value=s)}catch(s){console.error(s)}},F=async(s,i=null,b=0)=>{if(L.value=b,a.value.tax=b==1?2.5:3,a.value.subject_id=null,N=="mentor")a.value.subject_id=s[0].subjects[0].id;else try{const g=await U.get("api/v1/user/mentor-tutors/"+i+"/subjects");g&&(h.value=g)}catch(g){console.error(g)}},D=async(s,i,b)=>{try{const g=await U.get("api/v1/component/fee/"+s+"/"+i+"/"+b);g&&(a.value.individual_fee=g.fee_individual)}catch(g){console.error(g)}},q=async()=>{try{const s=await U.get("api/v1/curriculum/component/list");s&&(z.value=s),console.log(s)}catch(s){console.error(s)}},f=async()=>{var i,b;a.value.mentortutor_email=_.value.email;const{valid:s}=await r.value.validate();if(s){c.value=!0;try{const g=await U.post("api/v1/timesheet/create",a.value);g&&(X("success",g.message,"bottom-end"),d("reload"),selected.value=[],a.value={ref_id:[],mentortutor_email:null,subject_id:null,subject_name:null,inhouse_id:null,package_id:null,duration:"",notes:"",pic_id:[],tax:null,individual_fee:""},_.value=[])}catch(g){if(console.log(g),(b=(i=g==null?void 0:g.response)==null?void 0:i.data)!=null&&b.errors){const u=g.response.data.errors;X("error",u,"bottom-end")}}finally{d("close"),c.value=!1}}};return ee(()=>{A(),A(!0),x(),v(),q()}),(s,i)=>(y(),C(ae,{width:"600","prepend-icon":"ri-send-plane-line",title:"Assign to Tutor"},{default:t(()=>[l(le,null,{default:t(()=>[l(ie,{onSubmit:se(f,["prevent"]),ref_key:"formData",ref:r,"validate-on":"input"},{default:t(()=>[l(te,null,{default:t(()=>{var b,g;return[l(V,{md:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(_),"onUpdate:modelValue":[i[0]||(i[0]=u=>Y(_)?_.value=u:null),i[1]||(i[1]=u=>F(e(_).roles,e(_).uuid,e(_).has_npwp))],label:"Tutor Name",items:e(B),"item-props":u=>({title:u.full_name,subtitle:u.roles.map(ce=>ce.name).join(", ")}),rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"]),e(L)!=null?(y(),C(de,{key:0,color:e(L)==1?"success":"error",class:"py-1 mt-2"},{default:t(()=>[l(j,{icon:"ri-error-warning-line",class:"mr-2"}),k("small",null," Tutor "+O(e(L)==1?"already":"don`t")+" have NPWP ",1)]),_:1},8,["color"])):H("",!0)]),_:1}),l(V,{md:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(a).curriculum_id,"onUpdate:modelValue":i[2]||(i[2]=u=>e(a).curriculum_id=u),label:"Curriculum",items:e(z),"item-props":u=>({title:u.name}),rules:e(T).required,loading:e(c),disabled:e(c),"item-value":"id"},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),((g=(b=S.selected[0])==null?void 0:b.require)==null?void 0:g.toLowerCase())=="tutor"?(y(),C(V,{key:0,md:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(a).subject_name,"onUpdate:modelValue":[i[3]||(i[3]=u=>e(a).subject_name=u),i[4]||(i[4]=u=>D(e(_).id,e(a).subject_name,e(a).curriculum_id))],label:"Subject Tutoring",items:e(h),loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1})):H("",!0),l(V,{md:"8",col:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",label:"Package",modelValue:e(a).package_id,"onUpdate:modelValue":[i[5]||(i[5]=u=>e(a).package_id=u),G],items:e(M),"item-props":u=>({title:u.package!=null?u.type_of+" - "+u.package:u.type_of,subtitle:u.detail?u.detail/60+" Hours":"Customizable"}),"item-value":"id",rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),l(V,{md:"4",col:"7"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:+e(a).duration/60?"Minutes ("+e(a).duration/60+" Hours)":"Minutes",readonly:e($),modelValue:e(a).duration,"onUpdate:modelValue":i[6]||(i[6]=u=>e(a).duration=u),rules:e(T).required},null,8,["label","readonly","modelValue","rules"])]),_:1}),l(V,{md:"7",col:"5"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Fee/hours (Gross)",modelValue:e(a).individual_fee,"onUpdate:modelValue":i[7]||(i[7]=u=>e(a).individual_fee=u),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(V,{md:"5",col:"5"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Tax",modelValue:e(a).tax,"onUpdate:modelValue":i[8]||(i[8]=u=>e(a).tax=u),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(V,{md:"6",col:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(a).inhouse_id,"onUpdate:modelValue":i[9]||(i[9]=u=>e(a).inhouse_id=u),label:"Inhouse Mentor/Tutor",items:e(P),"item-props":u=>({title:u.full_name}),"item-value":"uuid",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","item-props","loading","disabled","rules"])]),_:1}),l(V,{md:"12"},{default:t(()=>[l(R,{variant:"solo",multiple:"",clearable:"",chips:"",label:"PIC",modelValue:e(a).pic_id,"onUpdate:modelValue":i[10]||(i[10]=u=>e(a).pic_id=u),items:e(I),"item-title":"full_name","item-value":"id",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1}),l(V,{md:"12"},{default:t(()=>[l(ue,{label:"Notes",modelValue:e(a).notes,"onUpdate:modelValue":i[11]||(i[11]=u=>e(a).notes=u),variant:"solo"},null,8,["modelValue"])]),_:1})]}),_:1}),l(re,{class:"mt-5"},{default:t(()=>[l(K,{color:"error",type:"button",onClick:i[12]||(i[12]=b=>d("close"))},{default:t(()=>[l(j,{icon:"ri-close-line",class:"me-3"}),E(" Close ")]),_:1}),l(ne),l(K,{color:"success",type:"submit"},{default:t(()=>[E(" Save "),l(j,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1}))}},ol={__name:"program_add_specialist",props:{selected:Object},emits:["close","reload"],setup(o,{emit:w}){var D,q;const S=o,d=w,c=p(!1),_=p([]),B=p([]),z=p([]),h=p([]),M=p([]),I=p([]),P=p(!1),$=(q=(D=S.selected[0])==null?void 0:D.require)==null?void 0:q.toLowerCase(),N=p(null),L=p(),r=p({ref_id:S.selected.map(f=>f.id),mentortutor_email:null,subject_id:null,inhouse_id:null,package_id:null,duration:"",tax:null,individual_fee:null,notes:"",pic_id:[]}),a=async(f=!1)=>{const m=$=="mentor"?"External Mentor":$,n=f?"api/v1/user/mentor-tutors?inhouse=true&role="+$:"api/v1/user/mentor-tutors?role="+m;try{const s=await U.get(n);s&&(f?I.value=Object.values(s):B.value=s)}catch(s){console.error(s)}},A=async()=>{try{const f=await U.get("api/v1/package/component/list?category="+$);f&&(h.value=f)}catch(f){console.error(f)}},x=()=>{const f=r.value.package_id,m=h.value.findIndex(s=>s.id===f);let n=h.value[m];n.detail?(P.value=!0,r.value.duration=n.detail):(P.value=!1,r.value.duration=null)},G=async()=>{try{const f=await U.get("api/v1/user/component/list");f&&(M.value=f)}catch(f){console.error(f)}},v=async(f,m=null,n=0)=>{var s,i,b,g;if(r.value.subject_id=null,N.value=n,r.value.tax=n==1?2.5:3,$=="mentor")r.value.subject_id=(i=(s=f[0])==null?void 0:s.subjects[0])==null?void 0:i.id,r.value.individual_fee=(g=(b=f[0])==null?void 0:b.subjects[0])==null?void 0:g.fee_individual;else try{const u=await U.get("api/v1/user/mentor-tutors/"+m+"/subjects");u&&(z.value=u)}catch(u){console.error(u)}},F=async()=>{var m,n;r.value.mentortutor_email=_.value.email;const{valid:f}=await L.value.validate();if(f){c.value=!0;try{const s=await U.post("api/v1/timesheet/create",r.value);s&&(X("success",s.message,"bottom-end"),d("reload"),selected.value=[],r.value={ref_id:[],mentortutor_email:null,subject_id:null,subject_name:null,inhouse_id:null,package_id:null,duration:"",notes:"",pic_id:[],tax:null,individual_fee:""},_.value=[])}catch(s){if((n=(m=s==null?void 0:s.response)==null?void 0:m.data)!=null&&n.errors){const i=s.response.data.errors;X("error",i,"bottom-end")}}finally{d("close"),c.value=!1}}};return ee(()=>{a(),a(!0),A(),G()}),(f,m)=>(y(),C(ae,{width:"650","prepend-icon":"ri-send-plane-line",title:"Assign to External Mentor"},{default:t(()=>[l(le,null,{default:t(()=>[l(ie,{onSubmit:se(F,["prevent"]),ref_key:"formData",ref:L,"validate-on":"input"},{default:t(()=>[l(te,null,{default:t(()=>[l(V,{md:"12",cols:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(_),"onUpdate:modelValue":[m[0]||(m[0]=n=>Y(_)?_.value=n:null),m[1]||(m[1]=n=>v(e(_).roles,e(_).uuid,e(_).has_npwp))],label:"Mentor Name",items:e(B),"item-props":n=>({title:n.full_name,subtitle:n.roles.map(s=>s.name).join(", ")}),rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"]),e(N)!=null?(y(),C(de,{key:0,color:e(N)==1?"success":"error",class:"py-2 mt-2"},{default:t(()=>[l(j,{icon:"ri-error-warning-line",class:"mr-2"}),k("small",null," Mentor "+O(e(N)==1?"already":"don`t")+" have NPWP ",1)]),_:1},8,["color"])):H("",!0)]),_:1}),l(V,{md:"8",cols:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",label:"Package",modelValue:e(r).package_id,"onUpdate:modelValue":[m[2]||(m[2]=n=>e(r).package_id=n),x],items:e(h),"item-props":n=>({title:n.package!=null?n.type_of+" - "+n.package:n.type_of,subtitle:n.detail?n.detail/60+" Hours":"Customizable"}),"item-value":"id",rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),l(V,{md:"4",cols:"7"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:+e(r).duration/60?""+e(r).duration/60+" Hours":"Minutes",readonly:e(P),modelValue:e(r).duration,"onUpdate:modelValue":m[3]||(m[3]=n=>e(r).duration=n),rules:e(T).required},null,8,["label","readonly","modelValue","rules"])]),_:1}),l(V,{md:"7",cols:"5"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Fee/hours (Gross)",modelValue:e(r).individual_fee,"onUpdate:modelValue":m[4]||(m[4]=n=>e(r).individual_fee=n),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(V,{md:"5",cols:"5"},{default:t(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Tax",modelValue:e(r).tax,"onUpdate:modelValue":m[5]||(m[5]=n=>e(r).tax=n),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(V,{md:"6",cols:"12"},{default:t(()=>[l(R,{variant:"solo",clearable:"",modelValue:e(r).inhouse_id,"onUpdate:modelValue":m[6]||(m[6]=n=>e(r).inhouse_id=n),label:"Inhouse Mentor",items:e(I),"item-props":n=>({title:n.full_name}),"item-value":"uuid",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","item-props","loading","disabled","rules"])]),_:1}),l(V,{md:"6",cols:"12"},{default:t(()=>[l(R,{variant:"solo",multiple:"",clearable:"",chips:"",label:"PIC",modelValue:e(r).pic_id,"onUpdate:modelValue":m[7]||(m[7]=n=>e(r).pic_id=n),items:e(M),"item-title":"full_name","item-value":"id",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1}),l(V,{md:"12"},{default:t(()=>[l(ue,{label:"Notes",modelValue:e(r).notes,"onUpdate:modelValue":m[8]||(m[8]=n=>e(r).notes=n),variant:"solo"},null,8,["modelValue"])]),_:1})]),_:1}),l(re,{class:"mt-5"},{default:t(()=>[l(K,{color:"error",type:"button",onClick:m[9]||(m[9]=n=>d("close"))},{default:t(()=>[l(j,{icon:"ri-close-line",class:"me-3"}),E(" Close ")]),_:1}),l(ne),l(K,{color:"success",type:"submit"},{default:t(()=>[E(" Save "),l(j,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1}))}},sl=k("div",{class:"d-flex justify-between align-center"},[k("div",{class:"w-100"},[k("h4",null,"Program Name")])],-1),nl=k("th",{class:"text-uppercase",width:"1%"}," # ",-1),rl=k("th",{class:"text-uppercase text-center"},"Timesheet",-1),il=k("th",{class:"text-uppercase text-center"},"Student",-1),ul=k("th",{class:"text-uppercase text-center"},"School Name",-1),dl={class:"text-uppercase text-center"},cl={class:"text-center"},ml={class:"text-left",nowrap:""},pl={class:"text-left",nowrap:""},vl={key:0,class:"text-left",nowrap:""},fl={key:1,class:"text-left",nowrap:""},_l={key:0},gl=k("tr",null,[k("td",{colspan:"6",class:"text-center"}," Sorry, no data found. ")],-1),bl=[gl],yl={class:"d-flex justify-center mt-5"},Rl={__name:"program",props:{name:String},setup(o){const w=p([]),S=p(!1),d=o,c=p(1),_=p(),B=p(),z=p([]),h=p(!1),M=p([]),I=p(),P=async()=>{var F,D;w.value=[];const r=d.name,a="?page="+c.value,A=B.value?"&keyword="+B.value:"",x=I.value?"&program_name="+encodeURIComponent(I.value):"",v=r=="tutoring"?"api/v1/program/list"+a+A+x+"&paginate=true":"api/v1/request"+a+B+"&is_cancelled=true";try{h.value=!0;const q=await U.get(v);q&&(c.value=q.current_page,_.value=q.last_page,z.value=q),h.value=!1}catch(q){X("error",(D=(F=q.response)==null?void 0:F.data)==null?void 0:D.message,"bottom-end"),console.error(q),h.value=!1}},$=async()=>{try{const r=await U.get("api/v1/program/component/list");r&&(M.value=r)}catch(r){console.error(r)}},N=We(async r=>{c.value=1,B.value=r.target.value,await P()},1e3),L=r=>{window.open("/admin/timesheet/"+d.name+"/"+r)};return Fe(()=>{P()}),ee(()=>{P(),$()}),(r,a)=>{const A=Ee("VText");return y(),C(ae,null,{default:t(()=>[l(He,null,{default:t(()=>[sl]),_:1}),l(le,null,{default:t(()=>[l(te,{class:"my-1"},{default:t(()=>[d.name=="tutoring"?(y(),C(V,{key:0,cols:"12",md:"3"},{default:t(()=>[l(R,{clearable:"",modelValue:e(I),"onUpdate:modelValue":[a[0]||(a[0]=x=>Y(I)?I.value=x:null),P],label:"Program Name",items:e(M),"item-title":"program_name",placeholder:"Select Program Name",density:"compact",variant:"solo","hide-details":"","single-line":"",loading:e(h),disabled:e(h)},null,8,["modelValue","items","loading","disabled"])]),_:1})):H("",!0),l(V,{cols:"12",md:"3"},{default:t(()=>[l(W,{loading:e(h),disabled:e(h),"append-inner-icon":"ri-search-line",density:"compact",label:"Search",variant:"solo","hide-details":"","single-line":"",onInput:e(N)},null,8,["loading","disabled","onInput"])]),_:1}),l(V,{cols:"12",md:d.name=="tutoring"?6:9,class:"text-end"},{default:t(()=>[Re((y(),C(K,{density:"compact",color:e(w).length>0?"warning":"primary",class:"mb-2",disabled:!(e(w).length>0),onClick:a[1]||(a[1]=x=>S.value=!0)},{default:t(()=>[l(j,{icon:"ri-add-line",class:"me-3"}),E(" Assign "+O(e(w).length>1?"to Group":""),1)]),_:1},8,["color","disabled"])),[[Ze,"Generate Timesheet","start"]])]),_:1},8,["md"])]),_:1}),l(Ye,{modelValue:e(S),"onUpdate:modelValue":a[4]||(a[4]=x=>Y(S)?S.value=x:null),width:"auto",persistent:""},{default:t(()=>[d.name=="tutoring"?(y(),C(tl,{key:0,selected:e(w),onClose:a[2]||(a[2]=x=>S.value=!1),onReload:P},null,8,["selected"])):H("",!0),d.name=="specialist"?(y(),C(ol,{key:1,selected:e(w),onClose:a[3]||(a[3]=x=>S.value=!1),onReload:P},null,8,["selected"])):H("",!0)]),_:1},8,["modelValue"]),e(h)?(y(),C(Ke,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(y(),C(Qe,{key:1,class:"table-responsive"},{default:t(()=>{var x,G;return[k("thead",null,[k("tr",null,[nl,rl,il,ul,k("th",dl,O(d.name=="tutoring"?"Program Name":"Engagement Type"),1)])]),k("tbody",null,[(y(!0),Q(Oe,null,ze(e(z).data,(v,F)=>(y(),Q("tr",{key:F,class:Ge({"bg-secondary":e(w).includes(v.id)})},[k("td",null,[v.cancellation_reason?(y(),C(A,{key:0},{default:t(()=>[l(Z,{activator:"parent",location:"top"},{default:t(()=>[E(" Cancel: "+O(v.cancellation_reason),1)]),_:2},1024),l(j,{icon:"ri-subtract-line",color:"error"})]),_:2},1024)):(!v.timesheet_id||!v.scnd_timesheet_id)&&!v.cancellation_reason?(y(),C(Je,{key:1,modelValue:e(w),"onUpdate:modelValue":a[5]||(a[5]=D=>Y(w)?w.value=D:null),value:{id:v.id,require:v.require}},null,8,["modelValue","value"])):v.timesheet_id&&v.scnd_timesheet_id&&!v.cancellation_reason?(y(),C(j,{key:2,icon:"ri-check-line",color:"success"})):H("",!0)]),k("td",cl,[v.timesheet_id?(y(),C(A,{key:0,class:"cursor-pointer",onClick:D=>L(v.timesheet_id)},{default:t(()=>[l(j,{icon:"ri-file-check-line",class:"mx-1",color:"success"}),l(Z,{activator:"parent",location:"top"},{default:t(()=>[E("Already")]),_:1})]),_:2},1032,["onClick"])):(y(),C(A,{key:1},{default:t(()=>[l(j,{icon:"ri-file-close-line",class:"mx-1",color:"error"}),l(Z,{activator:"parent",location:"top"},{default:t(()=>[E("Not Yet")]),_:1})]),_:1})),v.scnd_timesheet_id?(y(),C(A,{key:2,class:"cursor-pointer",onClick:D=>L(v.scnd_timesheet_id)},{default:t(()=>[l(j,{icon:"ri-file-check-line",class:"mx-1",color:"success"}),l(Z,{activator:"parent",location:"top"},{default:t(()=>[E("Already")]),_:1})]),_:2},1032,["onClick"])):H("",!0)]),k("td",ml,[l(j,{icon:"ri-user-line",class:"me-3"}),E(" "+O(v.student_name),1)]),k("td",pl,O(v.student_school),1),d.name=="tutoring"?(y(),Q("td",vl,[l(j,{icon:"ri-bookmark-line",class:"me-3"}),E(" "+O(v.free_trial?"[TRIAL]":"")+" "+O(v.program_name),1)])):(y(),Q("td",fl,[l(j,{icon:"ri-bookmark-line",class:"me-3"}),E(" "+O(v.engagement_type),1)]))],2))),128))]),((G=(x=e(z))==null?void 0:x.data)==null?void 0:G.length)==0?(y(),Q("tfoot",_l,bl)):H("",!0)]}),_:1})),k("div",yl,[l(Xe,{modelValue:e(c),"onUpdate:modelValue":[a[6]||(a[6]=x=>Y(c)?c.value=x:null),P],length:e(_),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})}}};export{Rl as default};
