import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './templates/home/home.component';
import { AboutComponent } from './templates/about/about.component';
import { NotFoundComponent } from './templates/not-found/not-found.component';
import { Auth } from './tools/auth/index';
import { LoginComponent } from './templates/login/login.component';
import { NotAuth } from './tools/auth/notauth';
import { RegisterComponent } from './templates/register/register.component';
const routes: Routes = [
  { path: 'about', component: AboutComponent, canActivate: [Auth] },
  { path: 'login', component: LoginComponent, canActivate: [NotAuth] },
  { path: 'register', component: RegisterComponent, canActivate: [NotAuth] },
  { path: '', component: HomeComponent, canActivate: [Auth] },
  { path: '**', component: NotFoundComponent, canActivate: [Auth] }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
