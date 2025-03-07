import{Z as me,B as pe,$ as ve,a0 as fe,a1 as _e,a2 as be,a3 as ge,a4 as ye,a5 as Ve,a6 as ke,a7 as xe,a8 as we,a9 as Ce,D as he,E as Pe,K as Z,aa as je,ab as Te,ac as Se,ad as qe,ae as Ue,af as Ie,ag as Ne,ah as $e,ai as Ae,aj as De,ak as Be,b as l,al as Le,V as D,Q as oe,Y as Q,P as Me,r as p,e as ee,o as V,f as j,w as n,am as se,u as e,z as H,a as x,t as O,h as G,W,j as F,m as ne,A as I,s as X,an as Fe,l as Ee,x as Re,c as K,X as ze,F as Oe,n as Ge}from"./main-CzT7uzRK.js";import{r as T}from"./rules-B5G8qOzK.js";import{a as le,c as re,V as ae,b as He}from"./VCard-tEuXfKy8.js";import{V as ie}from"./VForm-_qgyrfcJ.js";import{V as te,a as k}from"./VRow-JoPojWIY.js";import{V as E}from"./VAutocomplete-GyIV6LGX.js";import{V as ue}from"./VTextarea-un1ORx3Z.js";import{d as We}from"./debounce-B1BoaA5C.js";import{V as Ye}from"./VDialog-DdXC2y6v.js";import{V as Ke,a as Qe}from"./VTable-BfmrBn65.js";import{V as Xe}from"./VPagination-CPoDEQCr.js";import{T as Ze}from"./index-Z5hdUKVe.js";import{V as Je}from"./VCheckbox-BBXEfmyO.js";import{V as J}from"./VTooltip-BvXBKISB.js";import"./VAvatar-CJXsJV-i.js";import"./VImg-DBnCC04G.js";import"./VList-DCqCLOcv.js";import"./ssrBoot-BgL4C7Wt.js";import"./VDivider-D_Q9DxiI.js";import"./VCheckboxBtn-GL2PgKne.js";import"./VSelectionControl-CeIzsl1E.js";import"./VSlideGroup-DKHHA9wt.js";const el=me("v-alert-title"),ll=["success","info","warning","error"],al=pe({border:{type:[Boolean,String],validator:t=>typeof t=="boolean"||["top","end","bottom","start"].includes(t)},borderColor:String,closable:Boolean,closeIcon:{type:ve,default:"$close"},closeLabel:{type:String,default:"$vuetify.close"},icon:{type:[Boolean,String,Function,Object],default:null},modelValue:{type:Boolean,default:!0},prominent:Boolean,title:String,text:String,type:{type:String,validator:t=>ll.includes(t)},...fe(),..._e(),...be(),...ge(),...ye(),...Ve(),...ke(),...xe(),...we(),...Ce({variant:"flat"})},"VAlert"),de=he()({name:"VAlert",props:al(),emits:{"click:close":t=>!0,"update:modelValue":t=>!0},setup(t,h){let{emit:S,slots:d}=h;const c=Pe(t,"modelValue"),f=Z(()=>{if(t.icon!==!1)return t.type?t.icon??`$${t.type}`:t.icon}),q=Z(()=>({color:t.color??t.type,variant:t.variant})),{themeClasses:R}=je(t),{colorClasses:w,colorStyles:B,variantClasses:N}=Te(q),{densityClasses:P}=Se(t),{dimensionStyles:$}=qe(t),{elevationClasses:A}=Ue(t),{locationStyles:C}=Ie(t),{positionClasses:a}=Ne(t),{roundedClasses:r}=$e(t),{textColorClasses:g,textColorStyles:z}=Ae(De(t,"borderColor")),{t:y}=Be(),M=Z(()=>({"aria-label":y(t.closeLabel),onClick(L){c.value=!1,S("click:close",L)}}));return()=>{const L=!!(d.prepend||f.value),U=!!(d.title||t.title),Y=!!(d.close||t.closable);return c.value&&l(t.tag,{class:["v-alert",t.border&&{"v-alert--border":!!t.border,[`v-alert--border-${t.border===!0?"start":t.border}`]:!0},{"v-alert--prominent":t.prominent},R.value,w.value,P.value,A.value,a.value,r.value,N.value,t.class],style:[B.value,$.value,C.value,t.style],role:"alert"},{default:()=>{var v,m;return[Le(!1,"v-alert"),t.border&&l("div",{key:"border",class:["v-alert__border",g.value],style:z.value},null),L&&l("div",{key:"prepend",class:"v-alert__prepend"},[d.prepend?l(oe,{key:"prepend-defaults",disabled:!f.value,defaults:{VIcon:{density:t.density,icon:f.value,size:t.prominent?44:28}}},d.prepend):l(D,{key:"prepend-icon",density:t.density,icon:f.value,size:t.prominent?44:28},null)]),l("div",{class:"v-alert__content"},[U&&l(el,{key:"title"},{default:()=>{var o;return[((o=d.title)==null?void 0:o.call(d))??t.title]}}),((v=d.text)==null?void 0:v.call(d))??t.text,(m=d.default)==null?void 0:m.call(d)]),d.append&&l("div",{key:"append",class:"v-alert__append"},[d.append()]),Y&&l("div",{key:"close",class:"v-alert__close"},[d.close?l(oe,{key:"close-defaults",defaults:{VBtn:{icon:t.closeIcon,size:"x-small",variant:"text"}}},{default:()=>{var o;return[(o=d.close)==null?void 0:o.call(d,{props:M.value})]}}):l(Q,Me({key:"close-btn",icon:t.closeIcon,size:"x-small",variant:"text"},M.value),null)])]}})}}}),tl={__name:"program_add",props:{selected:Object},emits:["close","reload"],setup(t,{emit:h}){var m,o;const S=t,d=h,c=p(!1),f=p([]);p([]);const q=p([]),R=p([]),w=p([]),B=p([]),N=p([]),P=p([]),$=p(!1),A=(o=(m=S.selected[0])==null?void 0:m.require)==null?void 0:o.toLowerCase(),C=p(null),a=p(),r=p({ref_id:S.selected.map(s=>s.id),mentortutor_email:null,subject_id:null,inhouse_id:null,package_id:null,tax:null,individual_fee:null,duration:"",notes:"",pic_id:[],curriculum_id:null}),g=async(s=!1)=>{const i=s?"api/v1/user/mentor-tutors?inhouse=true&role="+A:"api/v1/user/mentor-tutors?role="+A;try{const b=await I.get(i);b&&(s?P.value=Object.values(b):q.value=b)}catch(b){console.error(b)}},z=async()=>{try{const s=await I.get("api/v1/package/component/list?category="+A);s&&(B.value=s)}catch(s){console.error(s)}},y=()=>{const s=r.value.package_id,i=B.value.findIndex(_=>_.id===s);let b=B.value[i];b.detail?($.value=!0,r.value.duration=b.detail):($.value=!1,r.value.duration=null)},M=async()=>{try{const s=await I.get("api/v1/user/component/list");s&&(N.value=s)}catch(s){console.error(s)}},L=async(s,i=null,b=0)=>{if(C.value=b,r.value.tax=b==1?2.5:3,r.value.subject_id=null,A=="mentor")r.value.subject_id=s[0].subjects[0].id;else try{const _=await I.get("api/v1/user/mentor-tutors/"+i+"/subjects");_&&(w.value=_)}catch(_){console.error(_)}},U=async(s,i,b)=>{try{const _=await I.get("api/v1/component/fee/"+s+"/"+i+"/"+b);_&&(r.value.individual_fee=_.fee_individual)}catch(_){console.error(_)}},Y=async()=>{try{const s=await I.get("api/v1/curriculum/component/list");s&&(R.value=s)}catch(s){console.error(s)}},v=async()=>{var i,b;r.value.mentortutor_email=f.value.email;const{valid:s}=await a.value.validate();if(s){c.value=!0;try{const _=await I.post("api/v1/timesheet/create",r.value);_&&(X("success",_.message,"bottom-end"),d("reload"),selected.value=[],r.value={ref_id:[],mentortutor_email:null,subject_id:null,subject_name:null,inhouse_id:null,package_id:null,duration:"",notes:"",pic_id:[],tax:null,individual_fee:""},f.value=[])}catch(_){if(console.log(_),(b=(i=_==null?void 0:_.response)==null?void 0:i.data)!=null&&b.errors){const u=_.response.data.errors;X("error",u,"bottom-end")}}finally{d("close"),c.value=!1}}};return ee(()=>{g(),g(!0),z(),M(),Y()}),(s,i)=>(V(),j(ae,{width:"650","prepend-icon":"ri-send-plane-line",title:"Assign to Tutor"},{default:n(()=>[l(le,null,{default:n(()=>[l(ie,{onSubmit:se(v,["prevent"]),ref_key:"formData",ref:a,"validate-on":"input"},{default:n(()=>[l(te,null,{default:n(()=>{var b,_;return[l(k,{md:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(f),"onUpdate:modelValue":[i[0]||(i[0]=u=>H(f)?f.value=u:null),i[1]||(i[1]=u=>L(e(f).roles,e(f).uuid,e(f).has_npwp))],label:"Tutor Name",items:e(q),"item-props":u=>({title:u.full_name,subtitle:u.roles.map(ce=>ce.name).join(", ")}),rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"]),e(C)!=null?(V(),j(de,{key:0,color:e(C)==1?"success":"error",icon:"ri-error-warning-line",class:"py-2 mt-2"},{default:n(()=>[x("small",null," Tutor "+O(e(C)==1?"already":"don`t")+" have NPWP ",1)]),_:1},8,["color"])):G("",!0)]),_:1}),l(k,{md:"6",col:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(r).curriculum_id,"onUpdate:modelValue":i[2]||(i[2]=u=>e(r).curriculum_id=u),label:"Curriculum",items:e(R),"item-props":u=>({title:u.name}),rules:e(T).required,loading:e(c),disabled:e(c),"item-value":"id"},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),((_=(b=S.selected[0])==null?void 0:b.require)==null?void 0:_.toLowerCase())=="tutor"?(V(),j(k,{key:0,md:"6",col:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(r).subject_name,"onUpdate:modelValue":[i[3]||(i[3]=u=>e(r).subject_name=u),i[4]||(i[4]=u=>U(e(f).id,e(r).subject_name,e(r).curriculum_id))],label:"Subject Tutoring",items:e(w),loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1})):G("",!0),l(k,{md:"8",col:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",label:"Package",modelValue:e(r).package_id,"onUpdate:modelValue":[i[5]||(i[5]=u=>e(r).package_id=u),y],items:e(B),"item-props":u=>({title:u.package!=null?u.type_of+" - "+u.package:u.type_of,subtitle:u.detail?u.detail/60+" Hours":"Customizable"}),"item-value":"id",rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),l(k,{md:"4",col:"7"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:+e(r).duration/60?""+e(r).duration/60+" Hours":"Minutes",readonly:e($),modelValue:e(r).duration,"onUpdate:modelValue":i[6]||(i[6]=u=>e(r).duration=u),rules:e(T).required},null,8,["label","readonly","modelValue","rules"])]),_:1}),l(k,{md:"7",col:"5"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Fee/hours (Gross)",modelValue:e(r).individual_fee,"onUpdate:modelValue":i[7]||(i[7]=u=>e(r).individual_fee=u),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(k,{md:"5",col:"5"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Tax",modelValue:e(r).tax,"onUpdate:modelValue":i[8]||(i[8]=u=>e(r).tax=u),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(k,{md:"6",col:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(r).inhouse_id,"onUpdate:modelValue":i[9]||(i[9]=u=>e(r).inhouse_id=u),label:"Inhouse Mentor/Tutor",items:e(P),"item-props":u=>({title:u.full_name}),"item-value":"uuid",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","item-props","loading","disabled","rules"])]),_:1}),l(k,{md:"6",col:"12"},{default:n(()=>[l(E,{variant:"solo",multiple:"",clearable:"",chips:"",label:"PIC",modelValue:e(r).pic_id,"onUpdate:modelValue":i[10]||(i[10]=u=>e(r).pic_id=u),items:e(N),"item-title":"full_name","item-value":"id",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1}),l(k,{md:"12"},{default:n(()=>[l(ue,{label:"Notes",modelValue:e(r).notes,"onUpdate:modelValue":i[11]||(i[11]=u=>e(r).notes=u),variant:"solo"},null,8,["modelValue"])]),_:1})]}),_:1}),l(re,{class:"mt-5"},{default:n(()=>[l(Q,{color:"error",type:"button",onClick:i[12]||(i[12]=b=>d("close"))},{default:n(()=>[l(D,{icon:"ri-close-line",class:"me-3"}),F(" Close ")]),_:1}),l(ne),l(Q,{color:"success",type:"submit"},{default:n(()=>[F(" Save "),l(D,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1}))}},ol={__name:"program_add_specialist",props:{selected:Object},emits:["close","reload"],setup(t,{emit:h}){var U,Y;const S=t,d=h,c=p(!1),f=p([]),q=p([]),R=p([]),w=p([]),B=p([]),N=p([]),P=p(!1),$=(Y=(U=S.selected[0])==null?void 0:U.require)==null?void 0:Y.toLowerCase(),A=p(null),C=p(),a=p({ref_id:S.selected.map(v=>v.id),mentortutor_email:null,subject_id:null,inhouse_id:null,package_id:null,duration:"",tax:null,individual_fee:null,notes:"",pic_id:[]}),r=async(v=!1)=>{const m=$=="mentor"?"External Mentor":$,o=v?"api/v1/user/mentor-tutors?inhouse=true&role="+$:"api/v1/user/mentor-tutors?role="+m;try{const s=await I.get(o);s&&(v?N.value=Object.values(s):q.value=s)}catch(s){console.error(s)}},g=async()=>{try{const v=await I.get("api/v1/package/component/list?category="+$);v&&(w.value=v)}catch(v){console.error(v)}},z=()=>{const v=a.value.package_id,m=w.value.findIndex(s=>s.id===v);let o=w.value[m];o.detail?(P.value=!0,a.value.duration=o.detail):(P.value=!1,a.value.duration=null)},y=async()=>{try{const v=await I.get("api/v1/user/component/list");v&&(B.value=v)}catch(v){console.error(v)}},M=async(v,m=null,o=0)=>{var s,i,b,_;if(a.value.subject_id=null,A.value=o,a.value.tax=o==1?2.5:3,$=="mentor")a.value.subject_id=(i=(s=v[0])==null?void 0:s.subjects[0])==null?void 0:i.id,a.value.individual_fee=(_=(b=v[0])==null?void 0:b.subjects[0])==null?void 0:_.fee_individual;else try{const u=await I.get("api/v1/user/mentor-tutors/"+m+"/subjects");u&&(R.value=u)}catch(u){console.error(u)}},L=async()=>{var m,o;a.value.mentortutor_email=f.value.email;const{valid:v}=await C.value.validate();if(v){c.value=!0;try{const s=await I.post("api/v1/timesheet/create",a.value);s&&(X("success",s.message,"bottom-end"),d("reload"),selected.value=[],a.value={ref_id:[],mentortutor_email:null,subject_id:null,subject_name:null,inhouse_id:null,package_id:null,duration:"",notes:"",pic_id:[],tax:null,individual_fee:""},f.value=[])}catch(s){if((o=(m=s==null?void 0:s.response)==null?void 0:m.data)!=null&&o.errors){const i=s.response.data.errors;X("error",i,"bottom-end")}}finally{d("close"),c.value=!1}}};return ee(()=>{r(),r(!0),g(),y()}),(v,m)=>(V(),j(ae,{width:"650","prepend-icon":"ri-send-plane-line",title:"Assign to External Mentor"},{default:n(()=>[l(le,null,{default:n(()=>[l(ie,{onSubmit:se(L,["prevent"]),ref_key:"formData",ref:C,"validate-on":"input"},{default:n(()=>[l(te,null,{default:n(()=>[l(k,{md:"12",cols:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(f),"onUpdate:modelValue":[m[0]||(m[0]=o=>H(f)?f.value=o:null),m[1]||(m[1]=o=>M(e(f).roles,e(f).uuid,e(f).has_npwp))],label:"Mentor Name",items:e(q),"item-props":o=>({title:o.full_name,subtitle:o.roles.map(s=>s.name).join(", ")}),rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"]),e(A)!=null?(V(),j(de,{key:0,color:e(A)==1?"success":"error",icon:"ri-error-warning-line",class:"py-2 mt-2"},{default:n(()=>[x("small",null," Mentor "+O(e(A)==1?"already":"don`t")+" have NPWP ",1)]),_:1},8,["color"])):G("",!0)]),_:1}),l(k,{md:"8",cols:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",label:"Package",modelValue:e(a).package_id,"onUpdate:modelValue":[m[2]||(m[2]=o=>e(a).package_id=o),z],items:e(w),"item-props":o=>({title:o.package!=null?o.type_of+" - "+o.package:o.type_of,subtitle:o.detail?o.detail/60+" Hours":"Customizable"}),"item-value":"id",rules:e(T).required,loading:e(c),disabled:e(c)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),l(k,{md:"4",cols:"7"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:+e(a).duration/60?""+e(a).duration/60+" Hours":"Minutes",readonly:e(P),modelValue:e(a).duration,"onUpdate:modelValue":m[3]||(m[3]=o=>e(a).duration=o),rules:e(T).required},null,8,["label","readonly","modelValue","rules"])]),_:1}),l(k,{md:"7",cols:"5"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Fee/hours (Gross)",modelValue:e(a).individual_fee,"onUpdate:modelValue":m[4]||(m[4]=o=>e(a).individual_fee=o),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(k,{md:"5",cols:"5"},{default:n(()=>[l(W,{type:"number",variant:"solo",clearable:"",label:"Tax",modelValue:e(a).tax,"onUpdate:modelValue":m[5]||(m[5]=o=>e(a).tax=o),rules:e(T).required},null,8,["modelValue","rules"])]),_:1}),l(k,{md:"6",cols:"12"},{default:n(()=>[l(E,{variant:"solo",clearable:"",modelValue:e(a).inhouse_id,"onUpdate:modelValue":m[6]||(m[6]=o=>e(a).inhouse_id=o),label:"Inhouse Mentor",items:e(N),"item-props":o=>({title:o.full_name}),"item-value":"uuid",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","item-props","loading","disabled","rules"])]),_:1}),l(k,{md:"6",cols:"12"},{default:n(()=>[l(E,{variant:"solo",multiple:"",clearable:"",chips:"",label:"PIC",modelValue:e(a).pic_id,"onUpdate:modelValue":m[7]||(m[7]=o=>e(a).pic_id=o),items:e(B),"item-title":"full_name","item-value":"id",loading:e(c),disabled:e(c),rules:e(T).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1}),l(k,{md:"12"},{default:n(()=>[l(ue,{label:"Notes",modelValue:e(a).notes,"onUpdate:modelValue":m[8]||(m[8]=o=>e(a).notes=o),variant:"solo"},null,8,["modelValue"])]),_:1})]),_:1}),l(re,{class:"mt-5"},{default:n(()=>[l(Q,{color:"error",type:"button",onClick:m[9]||(m[9]=o=>d("close"))},{default:n(()=>[l(D,{icon:"ri-close-line",class:"me-3"}),F(" Close ")]),_:1}),l(ne),l(Q,{color:"success",type:"submit"},{default:n(()=>[F(" Save "),l(D,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1}))}},sl=x("div",{class:"d-flex justify-between align-center"},[x("div",{class:"w-100"},[x("h4",null,"Program Name")])],-1),nl=x("th",{class:"text-uppercase",width:"1%"}," # ",-1),rl=x("th",{class:"text-uppercase text-center"},"Student",-1),il=x("th",{class:"text-uppercase text-center"},"School Name",-1),ul={class:"text-uppercase text-center"},dl=x("th",{class:"text-uppercase text-center"},"Timesheet",-1),cl={key:2},ml={class:"text-left",nowrap:""},pl={class:"text-left",nowrap:""},vl={key:0,class:"text-left",nowrap:""},fl={key:1,class:"text-left",nowrap:""},_l={class:"text-center"},bl={key:0},gl=x("tr",null,[x("td",{colspan:"6",class:"text-center"}," Sorry, no data found. ")],-1),yl=[gl],Vl={class:"d-flex justify-center mt-5"},zl={__name:"program",props:{name:String},setup(t){const h=p([]),S=p(!1),d=t,c=p(1),f=p(),q=p(),R=p([]),w=p(!1),B=p([]),N=p(),P=async()=>{var M,L;h.value=[];const C=d.name,a="?page="+c.value,r=q.value?"&keyword="+q.value:"",g=N.value?"&program_name="+encodeURIComponent(N.value):"",y=C=="tutoring"?"api/v1/program/list"+a+r+g+"&paginate=true":"api/v1/request"+a+q+"&is_cancelled=true";try{w.value=!0;const U=await I.get(y);U&&(c.value=U.current_page,f.value=U.last_page,R.value=U),w.value=!1}catch(U){X("error",(L=(M=U.response)==null?void 0:M.data)==null?void 0:L.message,"bottom-end"),console.error(U),w.value=!1}},$=async()=>{try{const C=await I.get("api/v1/program/component/list");C&&(B.value=C)}catch(C){console.error(C)}},A=We(async()=>{c.value=1,await P()},1e3);return Fe(()=>{P()}),ee(()=>{P(),$()}),(C,a)=>{const r=Ee("VText");return V(),j(ae,null,{default:n(()=>[l(He,null,{default:n(()=>[sl]),_:1}),l(le,null,{default:n(()=>[l(te,{class:"my-1"},{default:n(()=>[d.name=="tutoring"?(V(),j(k,{key:0,cols:"12",md:"3"},{default:n(()=>[l(E,{clearable:"",modelValue:e(N),"onUpdate:modelValue":[a[0]||(a[0]=g=>H(N)?N.value=g:null),P],label:"Program Name",items:e(B),"item-title":"program_name",placeholder:"Select Program Name",density:"compact",variant:"solo","hide-details":"","single-line":"",loading:e(w),disabled:e(w)},null,8,["modelValue","items","loading","disabled"])]),_:1})):G("",!0),l(k,{cols:"12",md:"3"},{default:n(()=>[l(W,{loading:e(w),disabled:e(w),"append-inner-icon":"ri-search-line",density:"compact",label:"Search",variant:"solo","hide-details":"","single-line":"",modelValue:e(q),"onUpdate:modelValue":a[1]||(a[1]=g=>H(q)?q.value=g:null),onInput:e(A)},null,8,["loading","disabled","modelValue","onInput"])]),_:1}),l(k,{cols:"12",md:d.name=="tutoring"?6:9,class:"text-end"},{default:n(()=>[Re((V(),j(Q,{density:"compact",color:e(h).length>0?"warning":"primary",class:"mb-2",disabled:!(e(h).length>0),onClick:a[2]||(a[2]=g=>S.value=!0)},{default:n(()=>[l(D,{icon:"ri-add-line",class:"me-3"}),F(" Assign "+O(e(h).length>1?"to Group":""),1)]),_:1},8,["color","disabled"])),[[Ze,"Generate Timesheet","start"]])]),_:1},8,["md"])]),_:1}),l(Ye,{modelValue:e(S),"onUpdate:modelValue":a[5]||(a[5]=g=>H(S)?S.value=g:null),width:"auto",persistent:""},{default:n(()=>[d.name=="tutoring"?(V(),j(tl,{key:0,selected:e(h),onClose:a[3]||(a[3]=g=>S.value=!1),onReload:P},null,8,["selected"])):G("",!0),d.name=="specialist"?(V(),j(ol,{key:1,selected:e(h),onClose:a[4]||(a[4]=g=>S.value=!1),onReload:P},null,8,["selected"])):G("",!0)]),_:1},8,["modelValue"]),e(w)?(V(),j(Ke,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(V(),j(Qe,{key:1,class:"table-responsive"},{default:n(()=>{var g,z;return[x("thead",null,[x("tr",null,[nl,rl,il,x("th",ul,O(d.name=="tutoring"?"Program Name":"Engagement Type"),1),dl])]),x("tbody",null,[(V(!0),K(Oe,null,ze(e(R).data,(y,M)=>(V(),K("tr",{key:M,class:Ge({"bg-secondary":e(h).includes(y.id)})},[x("td",null,[!y.timesheet_id&&!y.cancellation_reason?(V(),j(Je,{key:0,modelValue:e(h),"onUpdate:modelValue":a[6]||(a[6]=L=>H(h)?h.value=L:null),value:{id:y.id,require:y.require}},null,8,["modelValue","value"])):y.timesheet_id&&!y.cancellation_reason?(V(),j(D,{key:1,icon:"ri-check-line",color:"success"})):y.cancellation_reason?(V(),K("div",cl,[l(J,{activator:"parent",location:"end"},{default:n(()=>[F("Cancelled")]),_:1}),l(D,{icon:"ri-subtract-line",color:"error"})])):G("",!0)]),x("td",ml,[l(D,{icon:"ri-user-line",class:"me-3"}),F(" "+O(y.student_name),1)]),x("td",pl,O(y.student_school),1),d.name=="tutoring"?(V(),K("td",vl,[l(D,{icon:"ri-bookmark-line",class:"me-3"}),F(" "+O(y.free_trial?"[TRIAL]":"")+" "+O(y.program_name),1)])):(V(),K("td",fl,[l(D,{icon:"ri-bookmark-line",class:"me-3"}),F(" "+O(y.engagement_type),1)])),x("td",_l,[y.timesheet_id?(V(),j(r,{key:0},{default:n(()=>[l(D,{icon:"ri-file-check-line",class:"mx-1",color:"success"}),l(J,{activator:"parent",location:"top"},{default:n(()=>[F("Already")]),_:1})]),_:1})):(V(),j(r,{key:1},{default:n(()=>[l(D,{icon:"ri-file-close-line",class:"mx-1",color:"error"}),l(J,{activator:"parent",location:"top"},{default:n(()=>[F("Not Yet")]),_:1})]),_:1}))])],2))),128))]),((z=(g=e(R))==null?void 0:g.data)==null?void 0:z.length)==0?(V(),K("tfoot",bl,yl)):G("",!0)]}),_:1})),x("div",Vl,[l(Xe,{modelValue:e(c),"onUpdate:modelValue":[a[7]||(a[7]=g=>H(c)?c.value=g:null),P],length:e(f),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})}}};export{zl as default};
