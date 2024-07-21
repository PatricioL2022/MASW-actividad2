import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CitapacienteComponent } from './citapaciente.component';

describe('CitapacienteComponent', () => {
  let component: CitapacienteComponent;
  let fixture: ComponentFixture<CitapacienteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CitapacienteComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CitapacienteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
