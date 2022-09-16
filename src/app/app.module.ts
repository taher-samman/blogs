import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LogoComponent } from './tools/logo/logo.component';
import { NavbarComponent } from './tools/navbar/navbar.component';
import { HomeComponent } from './templates/home/home.component';
import { AboutComponent } from './templates/about/about.component';
import { NotFoundComponent } from './templates/not-found/not-found.component';
import { LoginComponent } from './templates/login/login.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ProgressBarComponent } from './tools/progress-bar/progress-bar.component';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { RegisterComponent } from './templates/register/register.component';

@NgModule({
  declarations: [
    AppComponent,
    LogoComponent,
    NavbarComponent,
    HomeComponent,
    AboutComponent,
    NotFoundComponent,
    LoginComponent,
    ProgressBarComponent,
    RegisterComponent,
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    MatProgressBarModule,
    MatSnackBarModule,
    HttpClientModule,
    AppRoutingModule,
    BrowserAnimationsModule
  ],
  providers: [
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
