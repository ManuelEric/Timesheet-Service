import{B as le,C as ne,D as re,E as W,G as ie,H as ce,r as b,I as de,K,L as ue,M as me,N as he,O as Q,b as t,P as H,F as C,Q as fe,R as pe,V as N,S as ve,T as _e,e as we,f as P,w as f,A as L,s as j,o as l,a as e,W as ge,u as g,z as X,c as p,X as D,h as G,t as u,j as F,Y as ye}from"./main-qXfsbDxV.js";import{a as Ve}from"./avatar-1-BpD18F9D.js";import{a as ke,b as xe,c as be,d as Ce}from"./avatar-5-DCc5XOFQ.js";import{d as Ie}from"./debounce-IAC0XKs4.js";import{V as Y,b as Se,a as $}from"./VCard-0nDPb5C9.js";import{V as Pe,a as q}from"./VTable-YUNXAyGR.js";import{V as Fe}from"./VPagination-DeN2sUQK.js";import{V as Ne}from"./VAvatar-8XWfWrYa.js";import{m as Te,V as J}from"./VSelectionControl-DsOh91CE.js";import{V as De}from"./VDialog-BkesBgLA.js";import"./VImg-DfdL-2nd.js";const Be=le({indeterminate:Boolean,inset:Boolean,flat:Boolean,loading:{type:[Boolean,String],default:!1},...ne(),...Te()},"VSwitch"),Ae=re()({name:"VSwitch",inheritAttrs:!1,props:Be(),emits:{"update:focused":a=>!0,"update:modelValue":a=>!0,"update:indeterminate":a=>!0},setup(a,B){let{attrs:y,slots:n}=B;const m=W(a,"indeterminate"),v=W(a,"modelValue"),{loaderClasses:V}=ie(a),{isFocused:I,focus:A,blur:R}=ce(a),T=b(),_=de&&window.matchMedia("(forced-colors: active)").matches,r=K(()=>typeof a.loading=="string"&&a.loading!==""?a.loading:a.color),d=ue(),h=K(()=>a.id||`switch-${d}`);function s(){m.value&&(m.value=!1)}function o(i){var c,x;i.stopPropagation(),i.preventDefault(),(x=(c=T.value)==null?void 0:c.input)==null||x.click()}return me(()=>{const[i,c]=he(y),x=Q.filterProps(a),w=J.filterProps(a);return t(Q,H({class:["v-switch",{"v-switch--flat":a.flat},{"v-switch--inset":a.inset},{"v-switch--indeterminate":m.value},V.value,a.class]},i,x,{modelValue:v.value,"onUpdate:modelValue":M=>v.value=M,id:h.value,focused:I.value,style:a.style}),{...n,default:M=>{let{id:Z,messagesId:ee,isDisabled:te,isReadonly:ae,isValid:O}=M;const U={model:v,isValid:O};return t(J,H({ref:T},w,{modelValue:v.value,"onUpdate:modelValue":[S=>v.value=S,s],id:Z.value,"aria-describedby":ee.value,type:"checkbox","aria-checked":m.value?"mixed":void 0,disabled:te.value,readonly:ae.value,onFocus:A,onBlur:R},c),{...n,default:S=>{let{backgroundColorClasses:z,backgroundColorStyles:k}=S;return t("div",{class:["v-switch__track",_?void 0:z.value],style:k.value,onClick:o},[n["track-true"]&&t("div",{key:"prepend",class:"v-switch__track-true"},[n["track-true"](U)]),n["track-false"]&&t("div",{key:"append",class:"v-switch__track-false"},[n["track-false"](U)])])},input:S=>{let{inputNode:z,icon:k,backgroundColorClasses:se,backgroundColorStyles:oe}=S;return t(C,null,[z,t("div",{class:["v-switch__thumb",{"v-switch__thumb--filled":k||a.loading},a.inset||_?void 0:se.value],style:a.inset?void 0:oe.value},[n.thumb?t(fe,{defaults:{VIcon:{icon:k,size:"x-small"}}},{default:()=>[n.thumb({...U,icon:k})]}):t(pe,null,{default:()=>[a.loading?t(ve,{name:"v-switch",active:!0,color:O.value===!1?void 0:r.value},{default:E=>n.loader?n.loader(E):t(_e,{active:E.isActive,color:E.color,indeterminate:!0,size:"16",width:"2"},null)}):k&&t(N,{key:String(k),icon:k,size:"x-small"},null)]})])])}})}})}),{}}}),Re={class:"d-flex justify-between align-center"},Me=e("div",{class:"w-100"},[e("h4",null,"Tutor/Mentor")],-1),Ue={class:"w-25"},ze=e("thead",null,[e("tr",null,[e("th",{class:"text-uppercase",width:"1%"}," No "),e("th",{class:"text-uppercase text-center"},"Mentor/Tutor Name"),e("th",{class:"text-uppercase text-center"},"Email"),e("th",{class:"text-uppercase text-center"},"Role"),e("th",{nowrap:""},"Inhouse Mentor"),e("th",{class:"text-uppercase text-center"},"Phone Number"),e("th",{class:"text-uppercase text-center"},"Detail")])],-1),Ee={nowrap:""},Le={class:"text-start",nowrap:""},je={class:"text-start",nowrap:""},Ge={key:0},$e={class:"d-flex justify-center"},He={class:"text-start",nowrap:""},Oe={class:"text-center",nowrap:""},We={class:"d-flex justify-between align-center mb-3"},Ke=e("h4",{class:"w-100"},"Detail",-1),Qe=e("thead",null,[e("tr",null,[e("th",{class:"text-left",nowrap:""}," Subject Tutoring "),e("th",{nowrap:""},"Grade"),e("th",{nowrap:""},"Head"),e("th",{nowrap:""},"Fee Individual"),e("th",{nowrap:""},"Fee Group"),e("th",{nowrap:"",class:"text-end"}," Additional Fee ")])],-1),Xe={nowrap:""},Ye={nowrap:""},qe={nowrap:""},Je={nowrap:""},Ze={nowrap:""},et={class:"text-end",nowrap:""},tt={key:0},at=e("tr",null,[e("td",{colspan:"6",class:"text-center"}," Sorry, no data found. ")],-1),st=[at],ot={class:"d-flex justify-center mt-5"},vt={__name:"tutor",setup(a){const B=[Ve,ke,xe,be,Ce],y=b(1),n=b(),m=b(),v=b([]),V=b(!1),I=async()=>{var h,s;const _="?page="+y.value,r=m.value?"&keyword="+m.value:"",d="&paginate=true";try{V.value=!0;const o=await L.get("api/v1/user/mentor-tutors"+_+r+d);o&&(y.value=o.current_page,n.value=o.last_page,v.value=o),V.value=!1}catch(o){j("error",(s=(h=o.response)==null?void 0:h.data)==null?void 0:s.message,"bottom-end"),console.error(o),V.value=!1}},A=Ie(async()=>{y.value=1,await I()},1e3),R=async _=>{try{const r=await L.post("api/v1/auth/email/checking",{email:_})}catch(r){console.error(r)}},T=async(_,r,d)=>{var h,s;await R(d);try{const o=await L.put("api/v1/user/mentor-tutors/"+_,{inhouse:r?1:0});o&&j("success",o.message,"bottom-end")}catch(o){console.error(o),j("error",(s=(h=o.response)==null?void 0:h.data)==null?void 0:s.errors,"bottom-end")}};return we(()=>{I()}),(_,r)=>(l(),P(Y,null,{default:f(()=>[t(Se,null,{default:f(()=>[e("div",Re,[Me,e("div",Ue,[t(ge,{modelValue:g(m),"onUpdate:modelValue":r[0]||(r[0]=d=>X(m)?m.value=d:null),loading:g(V),disabled:g(V),"append-inner-icon":"ri-search-line",density:"compact",label:"Search",variant:"solo","hide-details":"","single-line":"",onInput:g(A)},null,8,["modelValue","loading","disabled","onInput"])])])]),_:1}),t($,null,{default:f(()=>[g(V)?(l(),P(Pe,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(l(),P(q,{key:1},{default:f(()=>{var d,h;return[ze,e("tbody",null,[(l(!0),p(C,null,D(g(v).data,(s,o)=>(l(),p("tr",{key:o},[e("td",null,u(parseInt(o)+1),1),e("td",Ee,[t(Ne,{size:"25",class:"avatar-center me-3",image:B[o%5]},null,8,["image"]),F(" "+u(s.full_name),1)]),e("td",Le,[t(N,{icon:"ri-mail-line",class:"me-3"}),F(" "+u(s.email),1)]),e("td",je,[t(N,{icon:"ri-user-line",class:"me-3"}),(l(!0),p(C,null,D(s.roles,(i,c)=>(l(),p("span",{key:c},[F(u(i.name)+" ",1),c<s.roles.length-1?(l(),p("span",Ge,", ")):G("",!0)]))),128))]),e("td",$e,[t(Ae,{modelValue:s.inhouse,"onUpdate:modelValue":[i=>s.inhouse=i,i=>T(s.uuid,s.inhouse,s.email)],value:parseInt("1")},null,8,["modelValue","onUpdate:modelValue","value"])]),e("td",He,[t(N,{icon:"ri-smartphone-line",class:"me-3"}),F(" "+u(s.phone),1)]),e("td",Oe,[t(De,{"max-width":"600"},{activator:f(({props:i})=>[t(N,H({icon:"ri-folder-info-line",class:"cursor-pointer",ref_for:!0},i),null,16)]),default:f(({isActive:i})=>[t(Y,null,{default:f(()=>[t($,{class:"py-5"},{default:f(()=>[e("div",We,[Ke,t(ye,{size:"x-small",color:"secondary",icon:"ri-close-line",onClick:c=>i.value=!1},null,8,["onClick"])]),s.roles.findIndex(c=>c.name==="Tutor")>=0?(l(),P(q,{key:0,density:"compact"},{default:f(()=>[Qe,e("tbody",null,[(l(!0),p(C,null,D(s.roles,(c,x)=>(l(),p(C,{key:x},[c.name=="Tutor"?(l(!0),p(C,{key:0},D(c.subjects,w=>(l(),p("tr",{key:w},[e("td",Xe,u(w.tutor_subject),1),e("td",Ye,u(w.grade),1),e("td",qe,u(w.head),1),e("td",Je,"Rp. "+u(new Intl.NumberFormat("id-ID").format(w.fee_individual)),1),e("td",Ze,"Rp. "+u(new Intl.NumberFormat("id-ID").format(w.fee_group)),1),e("td",et," Rp. "+u(new Intl.NumberFormat("id-ID").format(w.additional_fee)),1)]))),128)):G("",!0)],64))),128))])]),_:2},1024)):(l(),P($,{key:1,class:"text-center"},{default:f(()=>[F(" There is no tutoring subject ")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024)])]))),128))]),((h=(d=g(v))==null?void 0:d.data)==null?void 0:h.length)==0?(l(),p("tfoot",tt,st)):G("",!0)]}),_:1})),e("div",ot,[t(Fe,{modelValue:g(y),"onUpdate:modelValue":[r[1]||(r[1]=d=>X(y)?y.value=d:null),I],length:g(n),"total-visible":5,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1}))}};export{vt as default};
