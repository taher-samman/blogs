import { Component, Input } from '@angular/core';

@Component({
  selector: 'logo',
  templateUrl: './logo.component.html',
  styleUrls: ['./logo.component.less']
})
export class LogoComponent {
  @Input() baseUrl='';
  @Input() logoUrl='';
}
