import { cn } from "@/lib/utils";

interface FormProps extends React.FormHTMLAttributes<HTMLFormElement> {
  className?: string;
}

const Form = React.forwardRef<HTMLFormElement, FormProps>({
  className: "space-y-4",
  ...props,
}) => {
  return (
    <form className={cn("space-y-4", props.className)} {...props} />
  );
});

Form.displayName = "Form";

export { Form };
