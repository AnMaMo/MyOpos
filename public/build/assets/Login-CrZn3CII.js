import{h as k,i as y,v,o as n,f as w,T as x,c,w as d,a as o,u as s,Z as V,t as B,g as p,b as r,j as C,d as f,n as $,e as P}from"./app-CB0mAyMb.js";import{_ as q}from"./GuestLayout-DlF2B1L_.js";import{_ as g,a as _,b as h}from"./TextInput-DL_hMVwC.js";import{P as N}from"./PrimaryButton-BJqYpTZn.js";import"./ApplicationLogo-C3-_-p2X.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const U=["value"],L={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(l,{emit:e}){const i=e,m=l,t=k({get(){return m.checked},set(a){i("update:checked",a)}});return(a,u)=>y((n(),w("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":u[0]||(u[0]=b=>t.value=b),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,U)),[[v,t.value]])}},R={key:0,class:"mb-4 font-medium text-sm text-green-600"},S={class:"mt-4"},j={class:"block mt-4"},D={class:"flex items-center"},E=r("span",{class:"ms-2 text-sm text-gray-600"},"Remember me",-1),F={class:"flex items-center justify-end mt-4"},H={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(l){const e=x({email:"",password:"",remember:!1}),i=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(m,t)=>(n(),c(q,null,{default:d(()=>[o(s(V),{title:"Log in"}),l.status?(n(),w("div",R,B(l.status),1)):p("",!0),r("form",{onSubmit:P(i,["prevent"])},[r("div",null,[o(g,{for:"email",value:"Email"}),o(_,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=a=>s(e).email=a),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(h,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",S,[o(g,{for:"password",value:"Password"}),o(_,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=a=>s(e).password=a),required:"",autocomplete:"current-password"},null,8,["modelValue"]),o(h,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",j,[r("label",D,[o(L,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=a=>s(e).remember=a)},null,8,["checked"]),E])]),r("div",F,[l.canResetPassword?(n(),c(s(C),{key:0,href:m.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:d(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):p("",!0),o(N,{class:$(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:d(()=>[f(" Log in ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{H as default};
