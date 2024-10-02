import{_ as ye}from"./DeleteHandler.vue_vue_type_script_setup_true_lang-CYLBsFxo.js";import{r as y,l as G,o as D,f as Y,w as a,b as e,Z as ae,W as E,u as t,v as I,Y as N,V as k,j as x,m as se,A as j,s as M,$ as le,e as oe,a as s,x as X,c as z,X as he,F as me,t as h,z as Ve,h as be,k as ue,a0 as ke,i as we,P as xe,a1 as De,a2 as Ce,a3 as ge}from"./main-BnkyMi1j.js";import{r as P}from"./rules-B5G8qOzK.js";import{a as A,c as ie,V as R,b as F,d as te,e as $e}from"./VCard-l7JRB8-M.js";import{V as ne}from"./VForm-CMa7IMDw.js";import{V as H,a as w}from"./VRow-tHroqXF9.js";import{V as _e}from"./VTextarea-DIVDMaRV.js";import{V as O}from"./VDialog-BohZWXU5.js";import{a as ce,V as Z}from"./VTable-BSu19sq-.js";import{T as K}from"./index-CdVdr3HH.js";import{V as Te}from"./VCheckbox-r1ujmQ5-.js";import{V as Q}from"./VAutocomplete-yg5uiBNq.js";import{V as Me}from"./VDivider-s-BhqrPK.js";import{V as Se,a as ee,b as Ue}from"./VList-BoarnBUc.js";import"./VAvatar-hAo5C-Tu.js";import"./VImg-DSQrbyBe.js";import"./VTooltip-DMVaInIg.js";import"./VCheckboxBtn-Bm9Dz-9r.js";import"./VSelectionControl-CY68aKXA.js";import"./VSlideGroup-DWAVI8Dm.js";import"./ssrBoot-DWCNlBGc.js";const Ye={__name:"activity-add",props:{id:String},emits:["close","reload"],setup(L,{emit:b}){const V=L,d=b,u=y(),r=y({activity:null,description:null,date:null,start_time:null,end_time:null,start_date:null,end_date:null,meeting_link:null}),_=()=>{r.value={activity:null,description:null,date:null,start_time:null,end_time:null,start_date:null,end_date:null,meeting_link:null}},T=async()=>{const{valid:C}=await u.value.validate();if(C)try{const i=await j.post("api/v1/timesheet/"+V.id+"/activity",r.value);i&&M("success",i.message,"bottom-end")}catch(i){M("error",i.response.data.errors,"bottom-end")}finally{_(),d("reload"),d("close")}};return(C,i)=>{const f=G("DialogCloseBtn"),p=G("VDateInput");return D(),Y(R,{title:"New Activity"},{default:a(()=>[e(f,{variant:"text",size:"default",onClick:i[0]||(i[0]=l=>d("close"))}),e(A,null,{default:a(()=>[e(ne,{onSubmit:ae(T,["prevent"]),ref_key:"formData",ref:u,"validate-on":"input"},{default:a(()=>[e(H,null,{default:a(()=>[e(w,{cols:"12",class:"d-none"},{default:a(()=>[e(E,{modelValue:t(r).activity,"onUpdate:modelValue":i[1]||(i[1]=l=>t(r).activity=l),label:"Activity Name",placeholder:"Activity",variant:"solo"},null,8,["modelValue"])]),_:1}),e(w,{cols:"12"},{default:a(()=>[e(_e,{modelValue:t(r).description,"onUpdate:modelValue":i[2]||(i[2]=l=>t(r).description=l),label:"Meeting Discussion",placeholder:"Meeting Discussion",variant:"solo",rules:t(P).required},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"6",cols:"12"},{default:a(()=>[e(p,{modelValue:t(r).date,"onUpdate:modelValue":i[3]||(i[3]=l=>t(r).date=l),label:"Date",placeholder:"Select Date","prepend-icon":"",variant:"solo",rules:t(P).required},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"3",cols:"6"},{default:a(()=>[e(E,{type:"time",modelValue:t(r).start_time,"onUpdate:modelValue":i[4]||(i[4]=l=>t(r).start_time=l),label:"Start Time",placeholder:"Start Time",rules:t(P).required,variant:"solo",class:"mb-3",onChange:i[5]||(i[5]=l=>t(r).start_date=t(I)(t(r).date).format("YYYY-MM-DD")+" "+t(r).start_time+":00")},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"3",cols:"6"},{default:a(()=>[e(E,{type:"time",modelValue:t(r).end_time,"onUpdate:modelValue":i[6]||(i[6]=l=>t(r).end_time=l),label:"End Time",placeholder:"End Time",variant:"solo",onChange:i[7]||(i[7]=l=>t(r).end_date=t(I)(t(r).date).format("YYYY-MM-DD")+" "+t(r).end_time+":00")},null,8,["modelValue"])]),_:1}),e(w,{md:"12",cols:"12"},{default:a(()=>[e(E,{type:"text",modelValue:t(r).meeting_link,"onUpdate:modelValue":i[8]||(i[8]=l=>t(r).meeting_link=l),label:"Meeting Link",placeholder:"Meeting Link",variant:"solo",rules:t(P).url},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(ie,{class:"mt-5"},{default:a(()=>[e(N,{type:"button",color:"error",onClick:i[9]||(i[9]=l=>d("close"))},{default:a(()=>[e(k,{icon:"ri-close-line",class:"me-3"}),x(" Close ")]),_:1}),e(se),e(N,{type:"submit",color:"success"},{default:a(()=>[x(" Save "),e(k,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},je={__name:"activity-edit",props:{timesheet_id:Number,activity:String},emits:["close","reload"],setup(L,{emit:b}){const V=y(),d=L,u=b,r=le("updateReload"),_=y({activity:d==null?void 0:d.activity.activity,description:d==null?void 0:d.activity.description,date:new Date(d==null?void 0:d.activity.start_date),start_time:d==null?void 0:d.activity.start_time,end_time:d==null?void 0:d.activity.end_time,start_date:I(d==null?void 0:d.activity.start_date).format("YYYY-MM-DD")+" "+(d==null?void 0:d.activity.start_time)+":00",end_date:(d==null?void 0:d.activity.end_time)!=0?I(d==null?void 0:d.activity.start_date).format("YYYY-MM-DD")+" "+(d==null?void 0:d.activity.end_time)+":00":null,meeting_link:d==null?void 0:d.activity.meeting_link}),T=async()=>{var i,f;const{valid:C}=await V.value.validate();if(C)try{const p=await j.put("api/v1/timesheet/"+d.timesheet_id+"/activity/"+d.activity.id,_.value);p&&(M("success",p.message,"bottom-end"),u("reload"))}catch(p){if((f=(i=p==null?void 0:p.response)==null?void 0:i.data)!=null&&f.errors){const l=p.response.data.errors;let c="Validation errors:";if(typeof l!="string"){for(const o in l)l.hasOwnProperty(o)&&(c+=`
${o}: ${l[o].join(", ")}`);M("error",c,"bottom-end")}else M("error",p.response.data.errors,"bottom-end")}}finally{u("close"),setTimeout(()=>{r(!0)},3e3)}};return(C,i)=>{const f=G("DialogCloseBtn"),p=G("VDateInput");return D(),Y(R,{title:"Edit Activity"},{default:a(()=>[e(f,{variant:"text",size:"default",onClick:i[0]||(i[0]=l=>u("close"))}),e(A,null,{default:a(()=>[e(ne,{onSubmit:ae(T,["prevent"]),ref_key:"formData",ref:V,"validate-on":"input"},{default:a(()=>[e(H,null,{default:a(()=>[e(w,{cols:"12",class:"d-none"},{default:a(()=>[e(E,{modelValue:t(_).activity,"onUpdate:modelValue":i[1]||(i[1]=l=>t(_).activity=l),label:"Activity Name",placeholder:"Activity",variant:"solo"},null,8,["modelValue"])]),_:1}),e(w,{cols:"12"},{default:a(()=>[e(_e,{modelValue:t(_).description,"onUpdate:modelValue":i[2]||(i[2]=l=>t(_).description=l),label:"Meeting Discussion",rules:t(P).required,placeholder:"Meeting Discussion",variant:"solo"},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"6",cols:"12"},{default:a(()=>[e(p,{modelValue:t(_).date,"onUpdate:modelValue":i[3]||(i[3]=l=>t(_).date=l),label:"Date",placeholder:"Select Date","prepend-icon":"",variant:"solo",rules:t(P).required},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"3",cols:"6"},{default:a(()=>[e(E,{type:"time",modelValue:t(_).start_time,"onUpdate:modelValue":i[4]||(i[4]=l=>t(_).start_time=l),label:"Start Time",rules:t(P).required,placeholder:"Start Time",variant:"solo",onChange:i[5]||(i[5]=l=>t(_).start_date=t(I)(d==null?void 0:d.activity.date).format("YYYY-MM-DD")+" "+t(_).start_time+":00")},null,8,["modelValue","rules"])]),_:1}),e(w,{md:"3",cols:"6"},{default:a(()=>[e(E,{type:"time",modelValue:t(_).end_time,"onUpdate:modelValue":i[6]||(i[6]=l=>t(_).end_time=l),label:"End Time",placeholder:"End Time",variant:"solo",onChange:i[7]||(i[7]=l=>t(_).end_date=t(I)(d==null?void 0:d.activity.date).format("YYYY-MM-DD")+" "+t(_).end_time+":00")},null,8,["modelValue"])]),_:1}),e(w,{md:"12",cols:"12"},{default:a(()=>[e(E,{type:"text",modelValue:t(_).meeting_link,"onUpdate:modelValue":i[8]||(i[8]=l=>t(_).meeting_link=l),label:"Meeting Link",placeholder:"Meeting Link",variant:"solo",rules:t(P).url},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(ie,{class:"mt-5"},{default:a(()=>[e(N,{color:"error",onClick:i[9]||(i[9]=l=>u("close"))},{default:a(()=>[e(k,{icon:"ri-close-line",class:"me-3"}),x(" Close ")]),_:1}),e(se),e(N,{color:"success",type:"submit"},{default:a(()=>[x(" Save "),e(k,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},Pe={class:"d-flex justify-between align-center"},Le=s("div",{class:"w-100"},[s("h4",null,"Activity")],-1),qe=s("thead",null,[s("tr",null,[s("th",{class:"text-uppercase",width:"1%"}," No "),s("th",{class:"text-uppercase text-center"},"Meeting Discussion"),s("th",{class:"text-uppercase text-center"},"Date"),s("th",{class:"text-uppercase text-center"},"Start Time"),s("th",{class:"text-uppercase text-center"},"End Time"),s("th",{class:"text-uppercase text-center"},"Time Spent"),s("th",{class:"text-uppercase text-center"},"Status"),s("th",{class:"text-uppercase text-end"},"#")])],-1),Ne={width:"1%"},Ae={class:"d-none"},Ee={class:"text-start"},Re={class:"text-center"},Be={class:"text-center"},Ie={class:"text-center"},ze={class:"text-end"},Fe=["href"],Oe={__name:"timesheet-detail",props:{id:String},setup(L){const b=L,V=le("updateReload"),d=y([]),u=y(!1),r=y([{add:!1,edit:!1,delete:!1}]),_=y([]),T=async()=>{u.value=!0;try{const l=await j.get("api/v1/timesheet/"+b.id+"/activities");l&&(d.value=l)}catch(l){console.error(l)}finally{u.value=!1}},C=l=>{r.value[l]?r.value[l]=!1:r.value[l]=!0},i=(l,c)=>{_.value=c,C(l)},f=async()=>{var l,c,o;try{const n=await j.delete("api/v1/timesheet/"+b.id+"/activity/"+_.value.id);n&&(M("success",n.message,"bottom-end"),C("delete"))}catch(n){((l=n.response)==null?void 0:l.status)==400&&M("error",(o=(c=n.response)==null?void 0:c.data)==null?void 0:o.errors,"bottom-end")}finally{T(),V(!0)}},p=async l=>{var c,o;try{const n=await j.patch("api/v1/timesheet/"+b.id+"/activity/"+l.id,l);n&&M("success",n.message,"bottom-end")}catch(n){if((o=(c=n==null?void 0:n.response)==null?void 0:c.data)!=null&&o.errors){const m=n.response.data.errors;let v="Validation errors:";if(typeof m!="string"){for(const U in m)m.hasOwnProperty(U)&&(v+=`
${U}: ${m[U].join(", ")}`);M("error",v,"bottom-end")}else M("error",n.response.data.errors,"bottom-end")}}finally{T(),V(!0)}};return oe(()=>{T()}),(l,c)=>(D(),Y(R,null,{default:a(()=>[e(F,null,{default:a(()=>[s("div",Pe,[Le,X((D(),Y(N,{onClick:c[0]||(c[0]=o=>C("add"))},{default:a(()=>[e(k,{icon:"ri-add-line"})]),_:1})),[[K,"New Activity","start"]]),e(O,{modelValue:t(r).add,"onUpdate:modelValue":c[2]||(c[2]=o=>t(r).add=o),"max-width":"600",persistent:""},{default:a(()=>[e(Ye,{id:b.id,onClose:c[1]||(c[1]=o=>C("add")),onReload:T},null,8,["id"])]),_:1},8,["modelValue"])])]),_:1}),e(A,null,{default:a(()=>[t(u)?(D(),Y(Z,{key:1,type:"table"})):(D(),Y(ce,{key:0,class:"text-no-wrap",height:"400","fixed-header":""},{default:a(()=>[qe,s("tbody",null,[(D(!0),z(me,null,he(t(d),(o,n)=>(D(),z("tr",{key:n},[s("td",Ne,h(n+1),1),s("td",Ae,h(o.activity),1),s("td",Ee,h(o.description),1),s("td",null,h(l.$moment(o.start_date).format("dddd"))+", "+h(l.$moment(o.start_date).format("MMM Do YYYY")),1),s("td",Re,h(o.start_time),1),s("td",Be,h(o.end_time),1),s("td",Ie,[e(k,{icon:"ri-timer-2-line",class:"cursor-pointer me-3"}),x(" "+h(o.estimate)+" Minutes ",1)]),s("td",null,[X(e(Te,{color:"success",modelValue:o.status,"onUpdate:modelValue":[m=>o.status=m,m=>p(o)],value:"1","false-value":0},null,8,["modelValue","onUpdate:modelValue"]),[[K,o.status?"Completed":"Not Yet","start"]])]),s("td",ze,[e(N,{color:"primary",density:"compact",class:"me-1"},{default:a(()=>[s("a",{href:o.meeting_link,target:"_blank",class:"bg-primary"},[e(k,{icon:"ri ri-link"}),x(" Join ")],8,Fe)]),_:2},1024),X((D(),Y(N,{color:"warning",density:"compact",class:"me-1",onClick:m=>i("edit",o)},{default:a(()=>[e(k,{icon:"ri-edit-line",class:"cursor-pointer"})]),_:2},1032,["onClick"])),[[K,"Edit Activity","start"]]),X((D(),Y(N,{color:"error",density:"compact",onClick:m=>i("delete",o)},{default:a(()=>[e(k,{icon:"ri-delete-bin-line",class:"cursor-pointer"})]),_:2},1032,["onClick"])),[[K,"Delete Activity","start"]])])]))),128))])]),_:1}))]),_:1}),e(O,{modelValue:t(r).edit,"onUpdate:modelValue":c[4]||(c[4]=o=>t(r).edit=o),"max-width":"600",persistent:""},{default:a(()=>[e(je,{timesheet_id:b==null?void 0:b.id,activity:t(_),onClose:c[3]||(c[3]=o=>C("edit")),onReload:T},null,8,["timesheet_id","activity"])]),_:1},8,["modelValue"]),e(O,{modelValue:t(r).delete,"onUpdate:modelValue":c[6]||(c[6]=o=>t(r).delete=o),"max-width":"400",persistent:""},{default:a(()=>[e(ye,{title:"activity",onClose:c[5]||(c[5]=o=>C("delete")),onDelete:f})]),_:1},8,["modelValue"])]),_:1}))}},Ge={__name:"timesheet-transfer",props:{timesheet_id:Number,require:String},emits:["close","reload"],setup(L,{emit:b}){const V=y(),d=L,u=b,r=y([]),_=y([]),T=y([]),C=d.require.toLowerCase(),i=y(!1),f=y({mentortutor_email:null,subject_id:null}),p=async()=>{const o="api/v1/user/mentor-tutors?role="+C;i.value=!0;try{const n=await j.get(o);n&&(r.value=n)}catch(n){console.error(n)}finally{i.value=!1}},l=async(o,n=null)=>{if(f.value.subject_id=null,C=="mentor")f.value.subject_id=o[0].subjects[0].id;else{i.value=!0;try{const m=await j.get("api/v1/user/mentor-tutors/"+n+"/subjects");m&&(T.value=m)}catch(m){console.error(m)}finally{i.value=!1}}},c=async()=>{var n,m;f.value.mentortutor_email=_.value.email;const{valid:o}=await V.value.validate();if(o){i.value=!0;try{const v=await j.patch("api/v1/timesheet/"+d.timesheet_id+"/void",f.value);v&&(console.log(v),M("success",v.message,"bottom-end"),u("reload"),ue.push("/admin/timesheet/"+v.data.timesheet_id),f.value={mentortutor_email:null,subject_id:null},_.value=[])}catch(v){if(console.log(v),(m=(n=v==null?void 0:v.response)==null?void 0:n.data)!=null&&m.errors){const U=v.response.data.errors;M("error",U,"bottom-end")}}finally{u("close"),i.value=!1}}};return oe(()=>{p()}),(o,n)=>(D(),Y(R,{class:"mx-auto my-8",elevation:"16",width:"450"},{default:a(()=>[e(ne,{ref_key:"formData",ref:V,"validate-on":"input",onSubmit:ae(c,["prevent"])},{default:a(()=>[e(te,null,{default:a(()=>[e(F,null,{default:a(()=>[x(" Timesheet Ownership Transfer ")]),_:1}),e($e,null,{default:a(()=>[x(" Change Timesheet Handler ")]),_:1})]),_:1}),e(A,null,{default:a(()=>[e(H,null,{default:a(()=>{var m;return[e(w,{md:"12"},{default:a(()=>[e(Q,{variant:"solo",clearable:"",modelValue:t(_),"onUpdate:modelValue":[n[0]||(n[0]=v=>Ve(_)?_.value=v:null),n[1]||(n[1]=v=>l(t(_).roles,t(_).uuid))],label:"Mentor/Tutor",items:t(r),"item-props":v=>({title:v.full_name,subtitle:v.roles.map(U=>U.name).join(", ")}),rules:t(P).required,loading:t(i),disabled:t(i)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),((m=d.require)==null?void 0:m.toLowerCase())=="tutor"?(D(),Y(w,{key:0,md:"12"},{default:a(()=>[e(Q,{variant:"solo",clearable:"",modelValue:t(f).subject_id,"onUpdate:modelValue":n[2]||(n[2]=v=>t(f).subject_id=v),label:"Subject Tutoring",items:t(T),"item-title":"subject","item-value":"id",loading:t(i),disabled:t(i),rules:t(P).required},null,8,["modelValue","items","loading","disabled","rules"])]),_:1})):be("",!0)]}),_:1})]),_:1}),e(ie,{class:"mx-3 mb-3"},{default:a(()=>[e(N,{color:"error",onClick:n[3]||(n[3]=m=>u("close"))},{default:a(()=>[e(k,{icon:"ri-close-line",class:"me-3"}),x(" Close ")]),_:1}),e(se),e(N,{color:"success",type:"submit"},{default:a(()=>[x(" Save Changes "),e(k,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1}))}},He={__name:"user-edit",props:["id","item","package_id"],emits:["close","reload"],setup(L,{emit:b}){var U,B,J,W,fe,pe;const V=L,d=b,u=y([]),r=y([]),_=y([]),T=y([]),C=y(!1),i=y(!0),f=y(!0),p=y(),l=y({mentortutor_email:(U=V.item)==null?void 0:U.tutormentor_email,subject_id:(B=V.item)==null?void 0:B.subject_id,inhouse_id:(J=V.item)==null?void 0:J.inhouse_id,package_id:V.package_id,duration:(W=V.item)==null?void 0:W.duration,notes:(fe=V.item)==null?void 0:fe.notes,pic_id:(pe=V.item)==null?void 0:pe.pic_id}),c=async(S=!1)=>{f.value=!0;const $=S?"api/v1/user/mentor-tutors?inhouse=true":"api/v1/user/mentor-tutors";try{const q=await j.get($);q&&(S?T.value=Object.values(q):u.value=q)}catch(q){console.error(q)}finally{f.value=!1}},o=async()=>{f.value=!0;try{const S=await j.get("api/v1/package/component/list");S&&(r.value=S)}catch(S){console.error(S)}finally{f.value=!1}},n=()=>{const S=l.value.package_id,$=r.value.findIndex(g=>g.id===S);let q=r.value[$];q.detail?(C.value=!0,l.value.duration=q.detail):(C.value=!1,l.value.duration=null)},m=async()=>{f.value=!0;try{const S=await j.get("api/v1/user/component/list");S&&(_.value=S)}catch(S){console.error(S)}finally{f.value=!1}},v=async()=>{var $,q;const{valid:S}=await p.value.validate();if(S)try{const g=await j.put("api/v1/timesheet/"+V.id+"/update",l.value);g&&(l.value={mentortutor_email:null,subject_id:null,inhouse_id:null,package_id:null,duration:"",notes:"",pic_id:[]},M("success",g.message,"bottom-end"),d("reload"))}catch(g){if((q=($=g==null?void 0:g.response)==null?void 0:$.data)!=null&&q.errors){const de=g.response.data.errors;let ve="Validation errors:";for(const re in de)de.hasOwnProperty(re)&&(ve+=`
${re}: ${de[re].join(", ")}`);M("error",ve,"bottom-end")}}finally{d("close")}};return oe(()=>{c(!0),o(),m(),setTimeout(()=>{i.value=!1},2e3)}),(S,$)=>{const q=G("DialogCloseBtn");return D(),Y(R,{title:"Edit Detail"},{default:a(()=>[e(q,{variant:"text",size:"default",onClick:$[0]||($[0]=g=>d("close"))}),e(A,null,{default:a(()=>[e(ne,{onSubmit:ae(v,["prevent"]),ref_key:"formData",ref:p,"validate-on":"input"},{default:a(()=>[e(H,null,{default:a(()=>[e(w,{md:"8"},{default:a(()=>[e(Q,{variant:"solo",clearable:"",label:"Package",modelValue:t(l).package_id,"onUpdate:modelValue":[$[1]||($[1]=g=>t(l).package_id=g),n],items:t(r),"item-props":g=>({title:g.package!=null?g.type_of+" - "+g.package:g.type_of}),"item-value":"id",rules:t(P).required,loading:t(f),disabled:t(f)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),e(w,{md:"4"},{default:a(()=>[e(E,{type:"number",variant:"solo",clearable:"",label:+t(l).duration/60?"Minutes ("+t(l).duration/60+" Hours)":"Minutes",readonly:t(C),modelValue:t(l).duration,"onUpdate:modelValue":$[2]||($[2]=g=>t(l).duration=g),rules:t(P).required},null,8,["label","readonly","modelValue","rules"])]),_:1}),e(w,{md:"12"},{default:a(()=>[e(Q,{variant:"solo",clearable:"",modelValue:t(l).inhouse_id,"onUpdate:modelValue":$[3]||($[3]=g=>t(l).inhouse_id=g),label:"Inhouse Mentor/Tutor",items:t(T),"item-props":g=>({title:g.full_name}),"item-value":"uuid",rules:t(P).required,loading:t(f),disabled:t(f)},null,8,["modelValue","items","item-props","rules","loading","disabled"])]),_:1}),e(w,{md:"12"},{default:a(()=>[e(Q,{variant:"solo",multiple:"",clearable:"",chips:"",label:"PIC",modelValue:t(l).pic_id,"onUpdate:modelValue":$[4]||($[4]=g=>t(l).pic_id=g),items:t(_),"item-title":"full_name","item-value":"id",rules:t(P).required,loading:t(f),disabled:t(f)},null,8,["modelValue","items","rules","loading","disabled"])]),_:1}),e(w,{md:"12"},{default:a(()=>[e(_e,{label:"Notes",modelValue:t(l).notes,"onUpdate:modelValue":$[5]||($[5]=g=>t(l).notes=g),variant:"solo"},null,8,["modelValue"])]),_:1})]),_:1}),e(Me,{class:"my-3"}),e(ie,null,{default:a(()=>[e(N,{color:"error",type:"button",onClick:$[6]||($[6]=g=>d("close"))},{default:a(()=>[e(k,{icon:"ri-close-line",class:"me-3"}),x(" Close ")]),_:1}),e(se),e(N,{color:"success",type:"submit"},{default:a(()=>[x(" Save "),e(k,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},Je={class:"w-100"},We={class:"mt-3 font-weight-light"},Xe=s("hr",{class:"my-2"},null,-1),Ze={key:0},Ke=s("tr",{class:"bg-secondary"},[s("td",null,"Name"),s("td",null,"School"),s("td",null,"Grade")],-1),Qe={key:1},et=s("td",{width:"20%"},"Name",-1),tt=s("td",{width:"1%"},":",-1),lt=s("td",null,"School Name",-1),at=s("td",{width:"1%"},":",-1),st=s("td",null,"Grade",-1),ot=s("td",{width:"1%"},":",-1),it=s("td",null,"Email",-1),nt=s("td",{width:"1%"},":",-1),dt={class:"mt-5 font-weight-light"},rt=s("hr",{class:"my-2"},null,-1),ut=s("td",{width:"30%"},"Program",-1),ct=s("td",{width:"1%"},":",-1),mt=s("td",null,"Package",-1),_t=s("td",{width:"1%"},":",-1),ft=s("td",null,"Person in Charge",-1),pt=s("td",{width:"1%"},":",-1),vt={class:"ms-4",type:"1"},gt=s("td",null,"Tutor/Mentor",-1),yt=s("td",{width:"1%"},":",-1),ht=s("td",null,"Inhouse Tutor/Mentor",-1),bt=s("td",{width:"1%"},":",-1),Vt=s("td",null,"Update On",-1),kt=s("td",{width:"1%"},":",-1),wt={class:"d-flex align-end w-100"},xt={class:"m-0 mb-1 text-white"},Dt=s("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),Ct={class:"text-end w-100"},$t={class:"d-flex align-end w-100"},Tt={class:"m-0 mb-1 text-white"},Mt=s("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),St={class:"text-end w-100"},Ut={class:"d-flex align-end w-100"},Yt={class:"m-0 mb-1 text-white"},jt=s("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),Pt={class:"text-end w-100"},Lt={__name:"user-detail",props:{id:String},setup(L){const b=L,V=le("reloadData"),d=le("updateReload"),u=y([]),r=y([{edit:!1,void:!1,delete:!1}]),_=y(!1),T=async p=>{var l,c,o;_.value=!0;try{const n=await j.get("api/v1/timesheet/"+p+"/detail");n&&(u.value=n)}catch(n){((l=n.response)==null?void 0:l.status)==400&&(M("error",(o=(c=n.response)==null?void 0:c.data)==null?void 0:o.errors,"bottom-end"),ue.push("/admin/timesheet")),console.log(n)}finally{_.value=!1}},C=async()=>{var p,l,c;try{const o=await j.delete("api/v1/timesheet/"+b.id+"/delete");o&&(u.value=o,M("success",o.message,"bottom-end"),r.value.delete=!1,ue.push("/admin/timesheet"))}catch(o){((p=o.response)==null?void 0:p.status)==400&&M("error",(c=(l=o.response)==null?void 0:l.data)==null?void 0:c.errors,"bottom-end")}},i=p=>{r.value[p]?r.value[p]=!1:r.value[p]=!0},f=async(p,l)=>{var c;De();try{const o=await j.get("api/v1/timesheet/"+p+"/export",{responseType:"blob"});if(o){const n=window.URL.createObjectURL(new Blob([o],{type:'"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"'})),m=document.createElement("a");m.href=n,m.setAttribute("download",`timesheet_${l}.xlsx`),document.body.appendChild(m),m.click(),document.body.removeChild(m),window.URL.revokeObjectURL(n),Ce.close()}}catch(o){M("error",(c=o.response)==null?void 0:c.statusText,"bottom-end"),console.log(o)}};return oe(()=>{T(b.id)}),ke(()=>{V.value&&(T(b.id),d(!1))}),(p,l)=>{const c=G("router-link");return D(),Y(R,{class:"mb-3"},{default:a(()=>[e(F,{class:"d-flex justify-between align-center"},{default:a(()=>{var o;return[s("div",Je,[e(c,{to:"/admin/timesheet"},{default:a(()=>[e(k,{icon:"ri-arrow-left-line",color:"secondary",class:"me-2",size:"25"})]),_:1}),x(" Timesheet - "+h((o=t(u).packageDetails)==null?void 0:o.package_type),1)]),s("div",null,[e(we,{"close-on-content-click":!1,location:"bottom"},{activator:a(({props:n})=>[X((D(),Y(N,xe({color:"secondary"},n),{default:a(()=>[e(k,{icon:"ri-settings-3-line"})]),_:2},1040)),[[K,"Settings","start"]])]),default:a(()=>[e(Se,null,{default:a(()=>[e(ee,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:l[0]||(l[0]=n=>i("edit"))},[e(k,{icon:"ri-pencil-line",class:"me-2"}),x(" Edit TimeSheet ")])]),_:1}),e(ee,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:l[1]||(l[1]=n=>i("void"))},[e(k,{icon:"ri-exchange-2-line",class:"me-2"}),x(" Timesheet Ownership Transfer ")])]),_:1}),e(ee,null,{default:a(()=>[e(Ue,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:l[2]||(l[2]=n=>{var m,v,U,B,J,W;return f(b.id,((v=(m=t(u))==null?void 0:m.packageDetails)==null?void 0:v.package_type)+"-"+((B=(U=t(u))==null?void 0:U.packageDetails)==null?void 0:B.package_name)+"_"+((W=(J=t(u))==null?void 0:J.packageDetails)==null?void 0:W.tutormentor_name))})},[e(k,{icon:"ri-download-line",class:"me-2"}),x(" Download TimeSheet ")])]),_:1})]),_:1}),e(ee,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:l[3]||(l[3]=n=>i("delete"))},[e(k,{icon:"ri-delete-bin-line",class:"me-2"}),x(" Delete TimeSheet ")])]),_:1})]),_:1})]),_:1})])]}),_:1}),e(A,null,{default:a(()=>[t(_)?(D(),Y(H,{key:1},{default:a(()=>[e(w,{md:"7"},{default:a(()=>[e(Z,{type:"heading, paragraph, heading, paragraph",class:"mb-3"})]),_:1}),e(w,{md:"5"},{default:a(()=>[e(Z,{type:"text@3",color:"#16B1FF",class:"mb-3"}),e(Z,{type:"text@3",color:"#91c45e",class:"mb-3"}),e(Z,{type:"text@3",color:"#e05e5e",class:"mb-3"})]),_:1})]),_:1})):(D(),Y(H,{key:0,align:"center"},{default:a(()=>[e(w,{md:"7"},{default:a(()=>[s("h4",We,[e(k,{icon:"ri-user-line",size:"17",class:"me-2"}),x(" Basic Profile ")]),Xe,e(ce,{density:"compact"},{default:a(()=>{var o,n;return[((o=t(u).clientProfile)==null?void 0:o.length)>1?(D(),z("tbody",Ze,[Ke,(D(!0),z(me,null,he(t(u).clientProfile,m=>(D(),z("tr",null,[s("td",null,h(m.client_name),1),s("td",null,h(m.client_school),1),s("td",null,h(m.client_grade),1)]))),256))])):((n=t(u).clientProfile)==null?void 0:n.length)==1?(D(),z("tbody",Qe,[s("tr",null,[et,tt,s("td",null,h(t(u).clientProfile[0].client_name),1)]),s("tr",null,[lt,at,s("td",null,h(t(u).clientProfile[0].client_school),1)]),s("tr",null,[st,ot,s("td",null,h(t(u).clientProfile[0].client_grade),1)]),s("tr",null,[it,nt,s("td",null,h(t(u).clientProfile[0].client_mail),1)])])):be("",!0)]}),_:1}),s("h4",dt,[e(k,{icon:"ri-bookmark-line",class:"me-2",size:"17"}),x(" Package Details ")]),rt,e(ce,{density:"compact"},{default:a(()=>{var o,n,m,v,U,B;return[s("tbody",null,[s("tr",null,[ut,ct,s("td",null,h((o=t(u).packageDetails)==null?void 0:o.program_name),1)]),s("tr",null,[mt,_t,s("td",null,h(((n=t(u).packageDetails)==null?void 0:n.package_type)+" - "+((m=t(u).packageDetails)==null?void 0:m.package_name)),1)]),s("tr",null,[ft,pt,s("td",null,[s("ol",vt,[s("li",null,h((v=t(u).packageDetails)==null?void 0:v.pic_name),1)])])]),s("tr",null,[gt,yt,s("td",null,h((U=t(u).packageDetails)==null?void 0:U.tutormentor_name),1)]),s("tr",null,[ht,bt,s("td",null,h((B=t(u).packageDetails)==null?void 0:B.inhouse_name),1)]),s("tr",null,[Vt,kt,s("td",null,h(t(I)().format("LLL")),1)])])]}),_:1})]),_:1}),e(w,{md:"5"},{default:a(()=>[e(R,{color:"#16B1FF",class:"mb-2 d-flex align-center"},{default:a(()=>[s("div",null,[e(te,null,{default:a(()=>[e(F,{class:"text-white"},{default:a(()=>[x(" Total Minutes of Package ")]),_:1})]),_:1}),e(A,{class:"d-flex justify-between"},{default:a(()=>{var o;return[s("div",wt,[s("h1",xt,h((o=t(u).packageDetails)==null?void 0:o.duration_in_minutes),1),Dt])]}),_:1})]),e(A,null,{default:a(()=>[s("div",Ct,[e(k,{icon:"ri-calendar-schedule-line",size:"60"})])]),_:1})]),_:1}),e(R,{color:"#91c45e",class:"mb-2 d-flex align-center"},{default:a(()=>[s("div",null,[e(te,null,{default:a(()=>[e(F,{class:"text-white"},{default:a(()=>[x(" Total Minutes Spent ")]),_:1})]),_:1}),e(A,{class:"d-flex justify-between"},{default:a(()=>{var o;return[s("div",$t,[s("h1",Tt,h((o=t(u).packageDetails)==null?void 0:o.time_spent_in_minutes),1),Mt])]}),_:1})]),e(A,null,{default:a(()=>[s("div",St,[e(k,{icon:"ri-timer-flash-line",size:"60",color:"white"})])]),_:1})]),_:1}),e(R,{color:"#e05e5e",class:"mb-2 d-flex align-center"},{default:a(()=>[s("div",null,[e(te,null,{default:a(()=>[e(F,{class:"text-white"},{default:a(()=>[x(" Total Minutes Left ")]),_:1})]),_:1}),e(A,{class:"d-flex justify-between"},{default:a(()=>{var o,n;return[s("div",Ut,[s("h1",Yt,h(((o=t(u).packageDetails)==null?void 0:o.duration_in_minutes)-((n=t(u).packageDetails)==null?void 0:n.time_spent_in_minutes)),1),jt])]}),_:1})]),e(A,null,{default:a(()=>[s("div",Pt,[e(k,{icon:"ri-timer-2-line",size:"60"})])]),_:1})]),_:1})]),_:1})]),_:1}))]),_:1}),e(O,{modelValue:t(r).edit,"onUpdate:modelValue":l[6]||(l[6]=o=>t(r).edit=o),"max-width":"600",persistent:""},{default:a(()=>{var o;return[e(He,{item:t(u).editableColumns,package_id:(o=t(u).packageDetails)==null?void 0:o.package_id,id:b.id,onClose:l[4]||(l[4]=n=>i("edit")),onReload:l[5]||(l[5]=n=>T(b.id))},null,8,["item","package_id","id"])]}),_:1},8,["modelValue"]),e(O,{modelValue:t(r).delete,"onUpdate:modelValue":l[8]||(l[8]=o=>t(r).delete=o),"max-width":"400",persistent:""},{default:a(()=>[e(ye,{title:"timesheet",onDelete:C,onClose:l[7]||(l[7]=o=>i("delete"))})]),_:1},8,["modelValue"]),e(O,{modelValue:t(r).void,"onUpdate:modelValue":l[10]||(l[10]=o=>t(r).void=o),"max-width":"400",persistent:""},{default:a(()=>[e(Ge,{timesheet_id:b.id,require:t(u).editableColumns.tutormentor_role,onClose:l[9]||(l[9]=o=>i("void"))},null,8,["timesheet_id","require"])]),_:1},8,["modelValue"])]),_:1})}}},al={__name:"timesheet-detail",props:{id:Number},setup(L){const V=L.id,d=y(!1);return ge("reloadData",d),ge("updateReload",u=>{d.value=u}),(u,r)=>(D(),z(me,null,[e(Lt,{id:t(V)},null,8,["id"]),e(Oe,{id:t(V)},null,8,["id"])],64))}};export{al as default};
